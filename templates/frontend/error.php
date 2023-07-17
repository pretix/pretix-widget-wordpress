<p>
<?php
    echo __('Error:', $this->get_name());
    echo '<br/>';
    echo implode('<br/>', $this->get_errors());
?>
</p>