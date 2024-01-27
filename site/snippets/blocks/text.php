<?php
/** @var Kirby\Cms\Block $block
 * @var Kirby\Cms\Site $site
 */
?>
<?= $block->text()->replace($site->placeholders()->toOptions());
