<script>
   var aName = new Array()
<?php if (count($map) > 0) : ?>
   <?php foreach ($map as $row) : ?>
         aName.push("<?= $row['name']; ?>");
   <?php endforeach; ?>
<?php endif; ?>
</script>

<div class="wrap">
    <h2>URL Rotator</h2>
    <p></p>
    <table class="widefat">
        
        <tbody>
        <form method="post"> 
            <?php //settings_fields('wp_footer_pop_up_banner'); ?>
            <?php //@do_settings_fields('wp_footer_pop_up_banner'); ?>

           <!-- <tr style="background-color: lightgray">  -->
		   
		   <tr class="url-add-sec" style="border: 1px solid #c3c4c7; margin-button: 80px;">

                <td>
                   <!-- <label for="url_rotator_mgs_name"><?= site_url(); ?>/ </label> -->
					
                    <label for="url_rotator_mgs_name" style="font-size: 18px; font-weight: 500;">Rotator Key</label>
					</td>
					
					<td>
						<input type="text" class="" name="url_rotator_mgs_name" id="url_rotator_mgs_name" style="width: 60%;"/>
					
						<input type="submit" id="url_rotator_mgs_submit" name="submit"  value="Add New" style="margin-left: 20px;" />
						<p>The url to activate the jump. This will follow the blogpath.</p>
						<p>For example <?= site_url(); ?>/RotatorKey ...so no starting with a slash "/")</p>
						<p>Try "jump" or "jump.html" or "jump/page.html" all work!</p>
					
                </td>

                <td></td>

            </tr>
			</tbody>
			</table>
			
            </fieldset>
        </form>

			<h2>Active URL Rotator</h2>
			<table class="widefat">
			<thead>
            <tr>
                <th>Rotator URL</th>
                <th>Target Links</th>
            </tr>
			</thead>
			<tbody>




        <?php if (count($map) > 0) : ?>
           <?php foreach ($map as $row) : ?>
		   
              <tr class="result">
                  <td>
                      <?= site_url(); ?>/<?= $row['name']; ?>
                      <form class="url_rotator_mgs_delete_form" method="POST" action="tools.php?page=wp_url_rotator_mgs" style="display: inline">
                          <input type="hidden" value="<?= $row['name']; ?>" name="url_rotator_mgs_delete"/>
                          <input type="submit" value="Delete" />
                      </form>

                  <!--    <form class="url_rotator_mgs_reset_form" method="POST" action="tools.php?page=wp_url_rotator_mgs" style="display: inline">
                          <input type="hidden" value="<?= $row['name']; ?>" name="url_rotator_mgs_name"/>
                          <input type="submit" name="url_rotator_mgs_reset_submit" value="Reset View Count" />
                      </form>
					  
					  -->
                  </td>
                  <td>
                      <table class="widefat">
                          <thead>
                              <tr>
                                  <th>URL</th>
                                  <th>Total Click</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php foreach ($row['link'] as $key => $links) : ?>
                                 <tr>
                                     <td><?= $links['url']; ?></td>
                                     <td><?= $links['click']; ?></td>
                                     <td>
                                         <input type="submit" data-name="<?= $row['name']; ?>" data-key="<?= $key; ?>" data-url="<?= $links['url']; ?>" class="edit" value="Edit" />

                                         <form class="url_rotator_mgs_delete_url_form" method="POST" action="tools.php?page=wp_url_rotator_mgs" style="display: inline">
                                             <input type="hidden" value="<?= $row['name']; ?>" name="url_rotator_mgs_name"/>
                                             <input type="hidden" value="<?= $key; ?>" name="url_rotator_mgs_key"/>
                                             <input type="submit" name="url_rotator_mgs_delete_url" value="Remove" />
                                         </form>

                                     </td>
                                 </tr>
                              <?php endforeach; ?>

                              <tr style="background-color: #d3d3d373">
                          <form method="post"> 
                              <td>
                                  <label for="url_rotator_mgs_name">Target Link: </label>
                                  <input type="text" name="url_rotator_mgs_url" id="url_rotator_mgs_url_<?= $row['name']; ?>" style="font-size: 80%"/>
                                  <input type="hidden" value="<?= $row['name']; ?>" name="url_rotator_mgs_name"/>
                                  <input type="hidden" value="" id="url_rotator_mgs_key_<?= $row['name']; ?>"  name="url_rotator_mgs_key"/>
                              </td>

                              <td></td>

                              <td>
                                  <input type="submit" id="url_rotator_mgs_new_url_submit_<?= $row['name']; ?>" name="url_rotator_mgs_new_url_submit"  value="Add New" />
                                  <input type="button" class="url_rotator_mgs_new_url_cancel" id="url_rotator_mgs_new_url_cancel_<?= $row['name']; ?>" data-name="<?= $row['name']; ?>"  value="Cancel" style="display: none"/>
                              </td>
                          </form>
              </tr>
              </tbody>
          </table>
      </td>
      </tr>
   <?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

</div>