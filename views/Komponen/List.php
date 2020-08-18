<?php
$data = array();
$data['level'] = $level;
?>
<ul>
    <?php foreach ($data['level'] as $v => $k): ?>
    <li data-jstree='{"icon":"fa fa-random"}'>
        <?php echo implode(',', $k['rute']); ?> =>[<?php echo $k['step']->implode("jarak", '+'); ?>] <strong>
            <?php echo $k['jarak']; ?>Km</strong> (
        <?php echo $k['rute'][$k['kombi'][0]]; ?>,
        <?php echo $k['rute'][$k['kombi'][1]]; ?>)
        <?php if ($data['level']->min('jarak') == $k['jarak']): ?><strong class="text-danger"> Ini yang paling pendek</strong>
        <?php endif;?>
        <?php if (isset($k['cabang'])): ?>

        <?php kucing($k['cabang']);?>
        <?php endif;?>

    </li>
    <?php endforeach;?>
</ul>