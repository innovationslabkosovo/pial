			</div>
		</div>
		<!-- / main body -->

	</div>
	<!-- / wrapper -->

	<!-- footer -->
	<div id="footer" class="clearingfix">

		<div id="underfooter"></div>

		<!-- footer content -->
		<div class="wrapper floatholder rapidxwpr">

			<!-- footer credits -->
			<div class="footer-credits powered">
				Powered by the &nbsp;
				<a href="http://www.ushahidi.com/" target="_blank">
					<img src="<?php echo url::file_loc('img'); ?>media/img/footer-logo.png" alt="Ushahidi" class="footer-logo" />
				</a>
				&nbsp; Platform
			</div>
			<div class="footer-credits implemented">
				Implemented by  &nbsp; &nbsp;
				<a href="http://www.kosovoinnovations.org/" target="_blank">
					<img src="http://77.81.240.20/smoking_violations/media/img/ilk.png" alt="Innovations Lab" style="vertical-align:middle">
				</a> <span>&nbsp; &nbsp; &nbsp; &nbsp;</span>
			</div>
			<!-- / footer credits -->

			<!-- footer menu -->
			<div class="footermenu">
				<ul class="clearingfix">
					<li>
						<a class="item1" href="<?php echo url::site(); ?>">
							<?php echo Kohana::lang('ui_main.home'); ?>
						</a>
					</li>

					<li>
						<a href="<?php echo url::site()."reports"; ?>">
							<?php echo Kohana::lang('ui_main.reports'); ?>
						</a>
					</li>

					<?php if (Kohana::config('settings.site_contact_page')): ?>
					<li>
						<a href="<?php echo url::site()."contact"; ?>">
							<?php echo Kohana::lang('ui_main.contact'); ?>
						</a>
					</li>
					<?php endif; ?>

					<?php
					// Action::nav_main_bottom - Add items to the bottom links
					Event::run('ushahidi_action.nav_main_bottom');
					?>
				</ul>

				<?php if ($site_copyright_statement != ''): ?>
	      		<p><?php echo $site_copyright_statement; ?></p>
		      	<?php endif; ?>
		      	
			</div>
			<!-- / footer menu -->


		</div>
		<!-- / footer content -->

	</div>
	<!-- / footer -->

	<?php
	echo $footer_block;
	// Action::main_footer - Add items before the </body> tag
	Event::run('ushahidi_action.main_footer');
	?>
</body>
</html>
