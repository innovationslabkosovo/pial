<!-- main body -->
<div id="main" class="clearingfix">
	<div id="mainmiddle" class="floatbox withright">

	<?php if ($site_message != ''): ?>
		<div class="green-box">
			<h3><?php echo $site_message; ?></h3>
		</div>
	<?php endif; ?>
		<?php
		// Map and Timeline Blocks
		echo $div_map;
		echo $div_timeline;
		?>

		<!-- <div id="right" class="clearingfix"> -->
		<div id="custom-cat" class="clearingfix">
			<div id="right" class="cities" style="width: 440px;">
				<p><?php echo Kohana::lang('ui_main.go_to'); ?></p><br/>
				<select id="select_city" name="select_city" class="select">
					<option value="" selected="selected"><?php echo Kohana::lang('ui_main.choose_location'); ?></option>
					<option value="21.1639,42.6628"><?php echo Kohana::lang('ui_main.pr'); ?></option>
					<option value="20.4319,42.3794"><?php echo Kohana::lang('ui_main.gjk'); ?></option>
					<option value="21.46841,42.46340"><?php echo Kohana::lang('ui_main.gji'); ?></option>
					<option value="20.8667,42.8833"><?php echo Kohana::lang('ui_main.mt'); ?></option>
					<option value="20.2899,42.6598"><?php echo Kohana::lang('ui_main.pe'); ?></option>
					<option value="20.7355,42.2154"><?php echo Kohana::lang('ui_main.pz'); ?></option>
					<option value="21.15528,42.37055"><?php echo Kohana::lang('ui_main.fe'); ?></option>
				</select>
                <br/><br/>
				<div class="disclaimer red-bubbles">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="height:30px;">
                    <circle id="circle_color" cx="15" cy="15" r="10" fill="#52658c" fill-opacity="0.8" stroke="#52658c" stroke-opacity="0.3" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></circle>
                    </svg><p style="margin-left: 35px; margin-top: -23px;"><?php echo Kohana::lang('ui_main.red_bubble'); ?></p></div>
                <br/>
                <div class="disclaimer yellow-bubbles"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="height:30px;">
                        <circle cx="15" cy="15" r="10" fill="#f24163" fill-opacity="0.8" stroke="#590514" stroke-opacity="0.3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></circle>
                    </svg><p style="margin-left: 35px; margin-top: -23px;"><?php echo Kohana::lang('ui_main.yellow_bubble'); ?></p></div>
            </div>
			<?php
			// Action::main_sidebar_pre_filters - Add Items to the Entry Page before filters
			Event::run('ushahidi_action.main_sidebar_pre_filters');
			?>

			<ul id="category_switch" class="category-filters">
				<?php
				$color_css = 'class="category-icon swatch" style="background-color:#'.$default_map_all.'"';
				$all_cat_image = '';
				if ($default_map_all_icon != NULL)
				{
					$all_cat_image = html::image(array(
						'src'=>$default_map_all_icon
					));
					$color_css = 'class="category-icon"';
				}
				?>
				<li>
					<a class="active" id="cat_0" href="#">
						<span <?php echo $color_css; ?>><?php echo $all_cat_image; ?></span>
						<span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span>
					</a>
				</li>
				<?php
					foreach ($categories as $category => $category_info)
					{
						$category_title = html::escape($category_info[0]);
						$category_color = $category_info[1];
						$category_image = ($category_info[2] != NULL)
						    ? url::convert_uploaded_to_abs($category_info[2])
						    : NULL;
						$category_description = html::escape(Category_Lang_Model::category_description($category));

						$color_css = 'class="category-icon swatch" style="background-color:#'.$category_color.'"';
						if ($category_info[2] != NULL)
						{
							$category_image = html::image(array(
								'src'=>$category_image,
								));
							$color_css = 'class="category-icon"';
						}

						echo '<li>'
						    . '<a href="#" id="cat_'. $category .'" title="'.$category_description.'">'
						    . '<span '.$color_css.'>'.$category_image.'</span>'
						    . '<span class="category-title">'.$category_title.'</span>'
						    . '</a>';

						// Get Children
						echo '<div class="hide" id="child_'. $category .'">';
                        $i = 1;
						if (sizeof($category_info[3]) != 0)
						{
							echo '<ul>';
							foreach ($category_info[3] as $child => $child_info)
							{
								$child_title = html::escape($child_info[0]);
								$child_color = $child_info[1];
								$child_image = ($child_info[2] != NULL)
								    ? url::convert_uploaded_to_abs($child_info[2])
								    : NULL;
								$child_description = html::escape(Category_Lang_Model::category_description($child));

								$color_css = 'class="category-icon swatch" style="background-color:#'.$child_color.'"';
								if ($child_info[2] != NULL)
								{
									$child_image = html::image(array(
										'src' => $child_image
									));

									$color_css = 'class="category-icon"';
								}

                                if ($child_info[3] == 0) {
                                    echo '<li>'
                                        . '<a href="#" id="cat_'. $child .'" class="par_'. $i++ .'" title="'.$child_description.'">'
                                        . '<span '.$color_css.'>'.$child_image.'</span>'
                                        . '<span class="category-title">'.$child_title.'</span>'
                                        . '</a>'
                                        . '</li>';
                                } else {
                                    $y = $i - 1;
                                    echo  '<li class="cat_cat" id="ch_'. $y .'">'
                                        . '<a href="#" id="cat_'. $child .'" title="'.$child_description.'">'
                                        . '<span '.$color_css.'>'.$child_image.'</span>'
                                        . '<span class="category-title">'.$child_title.'</span>'
                                        . '</a>'
                                        . '</li>';
                                }
							}
							echo '</ul>';
						}
						echo '</div></li>';
					}
				?>
			</ul>
			<!-- / category filters -->
	            <p class="disclaimertxt">
                    <?php $ministry = Kohana::lang('ui_main.ministry'); ?>
                    <?php $lab = Kohana::lang('ui_main.lab'); ?>
                    <?php $aak_url = Kohana::lang('ui_main.aak_url'); ?>
                    
                    <?php echo Kohana::lang('ui_main.first_disclaimer') 
                    	. '<a target="_blank" href="http://www.masht-gov.net/">' . $ministry . '</a>'
                        .Kohana::lang('ui_main.second_disclaimer') 
                        .'<br /><br />'
                        .Kohana::lang('ui_main.aak')
                        .'<a target="_blank" href="http://www.akreditimi-ks.org/">'. $aak_url .'</a>'
                        .Kohana::lang('ui_main.implemented_by')
                        . '<a target="_blank" href="http://www.kosovoinnovations.org">'. $lab .'</a>';?>
	            </p>
            <style>
                ul.category-filters li li.cat_cat {display:none;}
            </style>

			<?php if ($layers): ?>
				<!-- Layers (KML/KMZ) -->
				<div class="layers-filters clearingfix">
					<strong><?php echo Kohana::lang('ui_main.layers_filter');?>
						<span>
							[<a href="javascript:toggleLayer('kml_switch_link', 'kml_switch')" id="kml_switch_link">
								<?php echo Kohana::lang('ui_main.hide'); ?>
							</a>]
						</span>
					</strong>
				</div>
				<ul id="kml_switch" class="category-filters">
				<?php
					foreach ($layers as $layer => $layer_info)
					{
						$layer_name = $layer_info[0];
						$layer_color = $layer_info[1];
						$layer_url = $layer_info[2];
						$layer_file = $layer_info[3];

						$layer_link = ( ! $layer_url)
						    ? url::base().Kohana::config('upload.relative_directory').'/'.$layer_file
						    : $layer_url;

						echo '<li>'
						    . '<a href="#" id="layer_'. $layer .'">'
						    . '<span class="swatch" style="background-color:#'.$layer_color.'"></span>'
						    . '<span class="layer-name">'.$layer_name.'</span>'
						    . '</a>'
						    . '</li>';
					}
				?>
				</ul>
				<!-- /Layers -->
			<?php endif; ?>

			<?php
			// Action::main_sidebar - Add Items to the Entry Page Sidebar
			Event::run('ushahidi_action.main_sidebar');
			?>
		</div>
		<!-- / right column -->

	</div>
</div>
<!-- / main body -->
