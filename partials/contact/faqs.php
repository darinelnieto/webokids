   
<?php
/**
 * 
 * Partial Name: faqs
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$fqas = get_field('faqs_group');
if($fqas['fqas_list']):
    $key = 0;
?>
<section class="faqs-partial-c39f50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-11 col-lg-10">
                <div class="fqas-content">
                    <img src="<?= get_template_directory_uri() ?>/images/contact-favicon.svg" alt="Favicon" class="favicon">
                    <?php if($fqas['title']): ?>
                        <h2><?= $fqas['title']; ?></h2>
                    <?php endif; ?>
                    <div class="fqas-list">
                        <?php foreach($fqas['fqas_list'] as $item): $key++; ?>
                            <div class="fqa-item <?php if($key === 1): ?>active<?php endif; ?>">
                                <?php if($item['question']): ?>
                                    <div class="question">
                                        <h3><?= $item['question']; ?></h3>
                                    </div>
                                <?php endif; if($item['answer']): ?>
                                    <div class="answer">
                                        <p><?= $item['answer']; ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>