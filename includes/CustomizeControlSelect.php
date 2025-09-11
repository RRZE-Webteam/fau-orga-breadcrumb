<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

class CustomizeControlSelect extends \WP_Customize_Control
{
    /**
     * The type of control being rendered.
     *
     * @var string
     */
    public $type = 'select';

    /**
     * Render the control's content.
     *
     * @return void
     */
    public function render_content()
    {
        $input_id         = '_customize-input-' . $this->id;
        $description_id   = '_customize-description-' . $this->id;
        $describedby_attr = (! empty($this->description)) ? ' aria-describedby="' . esc_attr($description_id) . '" ' : '';

        if (empty($this->choices))
            return; ?>
        <label class="fau_orga_breadcrumb_optionpage">
            <?php if (! empty($this->label)) : ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php endif;
            if (! empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
            <select size="5" id="<?php echo esc_attr($input_id); ?>" class="" <?php echo $describedby_attr; ?> <?php $this->link(); ?>><?php echo  $this->choices; ?>
            </select>
        </label><?php
    }
}
