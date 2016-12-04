<?php
/**
 * @package   Toret Email Attachments
 * @author    Vladislav Musílek
 * @license   GPL-2.0+
 * @link      http://toret.cz
 * @copyright 2016 Toret.cz
 */

    
if(isset($_POST['setting'])){ 

  $this->save_options();
  
  wp_redirect(get_admin_url().'admin.php?page=toret-email-attachments');
   
}      
  
$option = get_option('toret-ea-option');

    
    
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
 
    <div class="t-col-9">
        <div class="toret-box box-info">
            <div class="box-header">
                <h3 class="box-title"><?php esc_html_e('Nastavení pluginu',$this->plugin_slug); ?></h3>
            </div>
            <div class="box-body">
                <form action="<?php echo admin_url( "admin.php?page={$this->plugin_slug}" ); ?>" method="post" style="margin-bottom:10px;">
                <?php wp_nonce_field( $this->plugin_slug . '-admin' ); ?>
        
                    <table class="table-bordered">
                        
                        <tr>
                            <th>
                                <?php esc_html_e('Přílohy pro český jazyk',$this->plugin_slug); ?>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <?php esc_html_e('První příloha',$this->plugin_slug); ?>
                            </td>
                            <td>
                                <input type="text" name="email-attachment-first-cs" id="email-attachment-first-cs" style="width:100%;" value="<?php if(!empty($option['email-attachment-first-cs'])){ echo esc_attr_e( $option['email-attachment-first-cs'] ); } ?>" />
                                <button type="button" class="btn btn-info insert-media"><?php esc_html_e( 'Vyberte soubor', $this->plugin_slug ); ?></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php esc_html_e('Druhá příloha',$this->plugin_slug); ?>
                            </td>
                            <td>
                                <input type="text" name="email-attachment-second-cs" id="email-attachment-second-cs" style="width:100%;" value="<?php if(!empty($option['email-attachment-second-cs'])){ echo esc_attr_e( $option['email-attachment-second-cs'] ); } ?>" />
                                <button type="button" class="btn btn-info insert-media"><?php esc_html_e( 'Vyberte soubor', $this->plugin_slug ); ?></button>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <?php esc_html_e('Přílohy pro slovenský jazyk',$this->plugin_slug); ?>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <?php esc_html_e('První příloha',$this->plugin_slug); ?>
                            </td>
                            <td>
                                <input type="text" name="email-attachment-first-sk" id="email-attachment-first-sk" style="width:100%;" value="<?php if(!empty($option['email-attachment-first-sk'])){ echo esc_attr_e( $option['email-attachment-first-sk'] ); } ?>" />
                                <button type="button" class="btn btn-info insert-media"><?php esc_html_e( 'Vyberte soubor', $this->plugin_slug ); ?></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php esc_html_e('Druhá příloha',$this->plugin_slug); ?>
                            </td>
                            <td>
                                <input type="text" name="email-attachment-second-sk" id="email-attachment-second-sk" style="width:100%;" value="<?php if(!empty($option['email-attachment-second-sk'])){ echo esc_attr_e( $option['email-attachment-second-sk'] ); } ?>" />
                                <button type="button" class="btn btn-info insert-media"><?php esc_html_e( 'Vyberte soubor', $this->plugin_slug ); ?></button>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <?php esc_html_e('Přílohy pro další jazyky (EN)',$this->plugin_slug); ?>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <?php esc_html_e('První příloha',$this->plugin_slug); ?>
                            </td>
                            <td>
                                <input type="text" name="email-attachment-first-en" id="email-attachment-first-en" style="width:100%;" value="<?php if(!empty($option['email-attachment-first-en'])){ echo esc_attr_e( $option['email-attachment-first-en'] ); } ?>" />
                                <button type="button" class="btn btn-info insert-media"><?php esc_html_e( 'Vyberte soubor', $this->plugin_slug ); ?></button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php esc_html_e('Druhá příloha',$this->plugin_slug); ?>
                            </td>
                            <td>
                                <input type="text" name="email-attachment-second-en" id="email-attachment-second-en" style="width:100%;" value="<?php if(!empty($option['email-attachment-second-en'])){ echo esc_attr_e( $option['email-attachment-second-en'] ); } ?>" />
                                <button type="button" class="btn btn-info insert-media"><?php esc_html_e( 'Vyberte soubor', $this->plugin_slug ); ?></button>
                            </td>
                        </tr>
                    
                    </table>
        
                    <input type="hidden" name="setting" value="ok" />
                    <input type="submit" class="btn btn-info btn-sm " value="<?php _e('Uložit',$this->plugin_slug); ?>" />
        
                </form>
            </div>
        </div>
    </div>

    <div class="clear"></div>

</div>


