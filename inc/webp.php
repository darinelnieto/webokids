<?php
/**
 * WebP en el front.
 *
 * - Crea una copia .webp junto a cada imagen subida (original y todos sus tamaños):
 *   foto.png -> foto.png.webp. Solo se guarda si pesa menos que el original.
 * - Las imágenes que ya existían se convierten por lotes con WP-Cron.
 * - En el front, src/srcset (y los fondos que pasen por webokids_webp_url()) usan la
 *   versión .webp si existe. Si no existe, se imprime la original.
 * - Los correos (WooCommerce / wp_mail) siguen usando PNG/JPG, porque varios clientes
 *   de correo no muestran WebP.
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

define( 'WEBOKIDS_WEBP_QUALITY', 82 );
define( 'WEBOKIDS_WEBP_BATCH', 15 );

/*================= Conversión =================*/

/**
 * true si el servidor puede generar WebP.
 */
function webokids_webp_supported() {
  static $supported = null;
  if ( null === $supported ) {
    $supported = wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) );
  }
  return $supported;
}

/**
 * Ruta de la copia WebP de un archivo.
 */
function webokids_webp_file( $file ) {
  return $file . '.webp';
}

/**
 * Crea la copia WebP de un archivo JPG/PNG. Devuelve true si existe al terminar.
 */
function webokids_create_webp( $file ) {
  if ( ! $file || ! file_exists( $file ) || ! preg_match( '/\.(jpe?g|png)$/i', $file ) ) {
    return false;
  }

  $webp = webokids_webp_file( $file );
  if ( webokids_webp_valid( $webp ) && filemtime( $webp ) >= filemtime( $file ) ) {
    return true;
  }

  if ( webokids_is_palette_png( $file ) ) {
    // GD no convierte PNG con paleta (PNG-8): se pasa a color verdadero conservando la transparencia.
    $saved = webokids_create_webp_from_palette_png( $file, $webp );
  } else {
    $editor = wp_get_image_editor( $file );
    if ( is_wp_error( $editor ) ) {
      return false;
    }
    // Al cambiar de formato, WordPress ignora set_quality() y usa su calidad por defecto
    // para WebP (86): se fuerza la nuestra solo mientras se guarda esta copia.
    $force_quality = function ( $quality, $mime_type ) {
      return 'image/webp' === $mime_type ? WEBOKIDS_WEBP_QUALITY : $quality;
    };
    add_filter( 'wp_editor_set_quality', $force_quality, 99, 2 );
    $editor->set_quality( WEBOKIDS_WEBP_QUALITY );
    $saved = ! is_wp_error( $editor->save( $webp, 'image/webp' ) );
    remove_filter( 'wp_editor_set_quality', $force_quality, 99 );
  }

  // Archivo vacío o inválido: se borra para no servir una imagen rota.
  if ( ! $saved || ! webokids_webp_valid( $webp ) ) {
    if ( file_exists( $webp ) ) {
      wp_delete_file( $webp );
    }
    return false;
  }

  // Si el WebP no ahorra peso, no tiene sentido servirlo.
  if ( filesize( $webp ) >= filesize( $file ) ) {
    wp_delete_file( $webp );
    return false;
  }

  return true;
}

/**
 * true si el archivo WebP existe, no está vacío y es una imagen válida.
 */
function webokids_webp_valid( $webp ) {
  clearstatcache( true, $webp );
  return file_exists( $webp ) && filesize( $webp ) > 0 && false !== @getimagesize( $webp );
}

/**
 * true si es un PNG con paleta (color type 3 en la cabecera IHDR).
 */
function webokids_is_palette_png( $file ) {
  if ( ! preg_match( '/\.png$/i', $file ) ) {
    return false;
  }
  $header = @file_get_contents( $file, false, null, 0, 26 );
  return is_string( $header ) && strlen( $header ) === 26 && ord( $header[25] ) === 3;
}

/**
 * Convierte un PNG con paleta a WebP con GD.
 */
function webokids_create_webp_from_palette_png( $file, $webp ) {
  if ( ! function_exists( 'imagecreatefrompng' ) || ! function_exists( 'imagewebp' ) || ! function_exists( 'imagepalettetotruecolor' ) ) {
    return false;
  }
  $image = @imagecreatefrompng( $file );
  if ( ! $image ) {
    return false;
  }
  imagepalettetotruecolor( $image );
  imagealphablending( $image, false );
  imagesavealpha( $image, true );
  $saved = @imagewebp( $image, $webp, WEBOKIDS_WEBP_QUALITY );
  imagedestroy( $image );
  return (bool) $saved;
}

/**
 * Archivos (original + tamaños) de un adjunto.
 */
function webokids_attachment_files( $attachment_id, $metadata = null ) {
  $file = get_attached_file( $attachment_id );
  if ( ! $file ) {
    return array();
  }

  $files    = array( $file );
  $metadata = $metadata ?: wp_get_attachment_metadata( $attachment_id );
  $dir      = trailingslashit( dirname( $file ) );

  // Original sin escalar (cuando WordPress creó una versión -scaled).
  if ( ! empty( $metadata['original_image'] ) ) {
    $files[] = $dir . $metadata['original_image'];
  }
  if ( ! empty( $metadata['sizes'] ) && is_array( $metadata['sizes'] ) ) {
    foreach ( $metadata['sizes'] as $size ) {
      if ( ! empty( $size['file'] ) ) {
        $files[] = $dir . $size['file'];
      }
    }
  }

  return array_unique( $files );
}

/**
 * Crea las copias WebP de un adjunto.
 */
function webokids_convert_attachment( $attachment_id, $metadata = null ) {
  if ( ! webokids_webp_supported() || ! wp_attachment_is_image( $attachment_id ) ) {
    return;
  }
  foreach ( webokids_attachment_files( $attachment_id, $metadata ) as $file ) {
    webokids_create_webp( $file );
  }
}

// Imágenes nuevas (y miniaturas regeneradas).
add_filter( 'wp_generate_attachment_metadata', function ( $metadata, $attachment_id ) {
  webokids_convert_attachment( $attachment_id, $metadata );
  return $metadata;
}, 20, 2 );

// Al borrar una imagen se borran también sus WebP.
add_action( 'delete_attachment', function ( $attachment_id ) {
  foreach ( webokids_attachment_files( $attachment_id ) as $file ) {
    $webp = webokids_webp_file( $file );
    if ( file_exists( $webp ) ) {
      wp_delete_file( $webp );
    }
  }
} );

/*================= Conversión de imágenes existentes (WP-Cron) =================*/

add_filter( 'cron_schedules', function ( $schedules ) {
  $schedules['webokids_every_5_minutes'] = array(
    'interval' => 5 * MINUTE_IN_SECONDS,
    'display'  => 'Cada 5 minutos (WebP Webokids)',
  );
  return $schedules;
} );

/**
 * Convierte un lote de imágenes existentes. Devuelve cuántas procesó.
 */
function webokids_webp_batch( $limit = WEBOKIDS_WEBP_BATCH ) {
  global $wpdb;

  $last_id = (int) get_option( 'webokids_webp_last_id', 0 );
  $ids     = $wpdb->get_col( $wpdb->prepare(
    "SELECT ID FROM {$wpdb->posts}
     WHERE post_type = 'attachment' AND post_mime_type IN ('image/jpeg','image/png') AND ID > %d
     ORDER BY ID ASC LIMIT %d",
    $last_id,
    $limit
  ) );

  if ( empty( $ids ) ) {
    update_option( 'webokids_webp_done', 1, false );
    wp_clear_scheduled_hook( 'webokids_webp_cron' );
    return 0;
  }

  foreach ( $ids as $id ) {
    webokids_convert_attachment( (int) $id );
    update_option( 'webokids_webp_last_id', (int) $id, false );
  }

  return count( $ids );
}
add_action( 'webokids_webp_cron', 'webokids_webp_batch' );

// Programa la conversión de las imágenes existentes hasta terminar.
add_action( 'init', function () {
  if ( get_option( 'webokids_webp_done' ) || ! webokids_webp_supported() ) {
    return;
  }
  if ( ! wp_next_scheduled( 'webokids_webp_cron' ) ) {
    wp_schedule_event( time() + MINUTE_IN_SECONDS, 'webokids_every_5_minutes', 'webokids_webp_cron' );
  }
} );

/*================= Salida en el front =================*/

/**
 * true cuando se deben imprimir WebP (front, sin correos ni feeds).
 */
function webokids_webp_enabled() {
  global $webokids_webp_in_email;
  if ( is_admin() && ! wp_doing_ajax() ) {
    return false;
  }
  if ( ! empty( $webokids_webp_in_email ) || is_feed() ) {
    return false;
  }
  return true;
}

// Correos: se desactiva mientras se arma el contenido.
add_action( 'woocommerce_email_header', function () {
  $GLOBALS['webokids_webp_in_email'] = true;
}, 1 );
add_action( 'woocommerce_email_footer', function () {
  $GLOBALS['webokids_webp_in_email'] = false;
}, 99 );
add_filter( 'wp_mail', function ( $args ) {
  $GLOBALS['webokids_webp_in_email'] = false;
  return $args;
} );

/**
 * Cambia una URL de uploads (JPG/PNG) por su WebP si existe.
 */
function webokids_webp_url( $url ) {
  static $cache = array();

  if ( ! $url || ! is_string( $url ) || ! webokids_webp_enabled() || ! preg_match( '/\.(jpe?g|png)(\?.*)?$/i', $url ) ) {
    return $url;
  }
  if ( isset( $cache[ $url ] ) ) {
    return $cache[ $url ];
  }

  $uploads = wp_get_upload_dir();
  $path    = preg_replace( '/\?.*$/', '', $url );
  // Soporta URLs con o sin protocolo y http/https.
  $base    = preg_replace( '#^https?:#', '', $uploads['baseurl'] );
  $rel     = preg_replace( '#^https?:#', '', $path );

  if ( strpos( $rel, $base ) !== 0 ) {
    return $cache[ $url ] = $url;
  }

  $file = $uploads['basedir'] . substr( $rel, strlen( $base ) );
  $webp = webokids_webp_file( $file );
  $cache[ $url ] = ( file_exists( $webp ) && filesize( $webp ) > 0 ) ? $path . '.webp' : $url;

  return $cache[ $url ];
}

// src de wp_get_attachment_image(), wp_get_attachment_image_url(), WooCommerce, etc.
add_filter( 'wp_get_attachment_image_src', function ( $image ) {
  if ( is_array( $image ) && ! empty( $image[0] ) ) {
    $image[0] = webokids_webp_url( $image[0] );
  }
  return $image;
}, 20 );

// srcset.
add_filter( 'wp_calculate_image_srcset', function ( $sources ) {
  if ( is_array( $sources ) ) {
    foreach ( $sources as $width => $source ) {
      $sources[ $width ]['url'] = webokids_webp_url( $source['url'] );
    }
  }
  return $sources;
}, 20 );

// Imágenes dentro del contenido (editor clásico, descripciones de producto).
add_filter( 'wp_content_img_tag', function ( $image ) {
  return preg_replace_callback( '/\ssrc="([^"]+)"/', function ( $m ) {
    return ' src="' . esc_url( webokids_webp_url( html_entity_decode( $m[1] ) ) ) . '"';
  }, $image );
}, 20 );
