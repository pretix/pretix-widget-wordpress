<div class="wrap">
    <h1>Pretix Ticket Settings</h1>
    <form method="post" action="options.php">
        <?php \settings_fields( 'pretix_ticket_settings_group' ); ?>
        <?php \do_settings_sections( 'pretix_ticket_settings_group' ); ?>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="pretix_ticket_url">Pretix URL</label></th>
                <td><input type="text" name="pretix_ticket_url" id="pretix_ticket_url" value="<?php echo \esc_attr( \get_option( 'pretix_ticket_url' ) ); ?>" class="regular-text"></td>
            </tr>
        </table>
        <?php \submit_button(); ?>
    </form>
</div>