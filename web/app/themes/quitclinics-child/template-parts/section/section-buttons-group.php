<?php if(get_sub_field('buttons_group')['buttons']) : ?>
    <div class="btn-block <?php  echo ((get_sub_field('buttons_group')['hide_buttons'] == 'true') ? ' hidden-mob ' :''); ?>" ">
    <?php foreach(get_sub_field('buttons_group')['buttons'] as $button) : ?>
        <a href="<?php echo $button['button']['url'] ;?>" class="btn-body btn-blue <?php  echo ($button['anchor'] ?  ' crane ' :''); ?>" data-mob-text="Apply now"><?php echo $button['button']['title'] ;?></a>
    <?php endforeach; ?>
    </div>
<?php endif; //edif buttons ?>