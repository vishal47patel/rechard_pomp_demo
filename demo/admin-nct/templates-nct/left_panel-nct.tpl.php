<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="start">
					<a href="<?php echo SITE_ADM_MOD; ?>home-nct">
						<i class="fa fa-home"></i>
						<span class="title">Dashboard</span>
					</a>
				</li>
          	<?php echo $this->getMenuList; ?>
           	</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
<!-- END SIDEBAR -->
