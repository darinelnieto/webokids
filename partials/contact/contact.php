   
<?php
/**
 * 
 * Partial Name: contact
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$contact = get_field('contact_us');
?>
<section class="contact-partial-a7f8d8">
    <div class="container">
        <div class="row" id="contact-contain">
            <?php if($contact['contact_items']): ?>
                <div class="col-12 col-md-7 col-lg-8 mb-5">
                    <h1 class="title"><?= the_title(); ?></h1>
                    <div class="row">
                        <?php foreach($contact['contact_items'] as $item): ?>
                            <div class="col-6">
                                <?php if($item['link']): ?>
                                    <a href="<?= $item['link']['url']; ?>" target="<?= $item['link']['target']; ?>" class="contact-link">
                                <?php endif; ?>
                                <div class="contact-item">
                                    <?php if($item['image']): ?>
                                        <img src="<?= $item['image']['url']; ?>" alt="<?= $item['image']['title']; ?>" width="<?= $item['image']['width']; ?>" heigth="<?= $item['image']['height']; ?>" class="icon">
                                    <?php endif; ?>
                                </div>
                                <?php if($item['link']): ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; if($contact['shortcode_form']): ?>
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="form-content">
                        <?php if($contact['form_title']): ?>
                            <h2><?= $contact['form_title']; ?></h2>
                        <?php endif; ?>
                        <div class="form">
                            <?= do_shortcode($contact['shortcode_form']); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
                    