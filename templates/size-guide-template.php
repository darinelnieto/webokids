   
<?php
/**
 * 
 * Template Name: size-guide
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header();
$sub_title = get_field('sub_title');
$text_before_title = get_field('text_before_title');
$guide_image = get_field('guide_image');
$guide_description = get_field('guide_description');
$guide_tabs = get_field('guide_tabs');
$key_controller = 0;
$key_body = 0;
?>
<main id="size-guide-template-21f420">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1><?= the_title(); ?></h1>
                    <div class="description-after-title">
                        <?php if($sub_title): ?>
                            <h2><?= $sub_title; ?></h2>
                        <?php endif; if($text_before_title): ?>
                            <p><?= $text_before_title; ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if($guide_image && $guide_description): ?>
                        <div class="feature-image-and-description">
                            <div class="image-contain">
                                <?= wp_get_attachment_image($guide_image['ID'] ?? '', 'large', false, array(
                                    'loading' => 'eager',
                                    'fetchpriority' => 'high',
                                    'decoding' => 'async',
                                    'alt' => 'Webo guía de tallas'
                                )) ?>
                            </div>
                            <div class="description">
                                <p><?= $guide_description; ?></p>
                            </div>
                        </div>
                    <?php endif; if($guide_tabs): ?>
                        <div class="tabs-contain">
                            <ul class="tab-contoller" role="tablist">
                                <?php foreach($guide_tabs as $tab): $key_controller++ ?>
                                    <li class="the-tab <?php if($key_controller === 1): ?>active<?php endif; ?>" role="presentation">
                                        <a href="#size-guide-item-<?= $key_controller; ?>" class="item" role="tab" id="size-guide-tab-<?= $key_controller; ?>" data-tab="item-<?= $key_controller; ?>" aria-controls="size-guide-item-<?= $key_controller; ?>" aria-selected="<?= $key_controller === 1 ? 'true' : 'false'; ?>">
                                            <span><?= $tab['cta']; ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="body-tab">
                                <?php foreach($guide_tabs as $body): $key_body++ ?>
                                    <div class="the-body item-<?= $key_body; ?> <?php if($key_body === 1): ?>active<?php endif; ?>" role="tabpanel" id="size-guide-item-<?= $key_body; ?>" aria-labelledby="size-guide-tab-<?= $key_body; ?>">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <?php foreach(($body['guide_list'] ?: array()) as $item): ?>
                                                        <th><?= $item['name']; ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php foreach(($body['guide_list'] ?: array()) as $item): ?>
                                                        <td><?= $item['option_one']; ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                                <tr>
                                                    <?php foreach(($body['guide_list'] ?: array()) as $item): ?>
                                                        <td><?= $item['option_two']; ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
                    