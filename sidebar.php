<?php if ( is_dynamic_sidebar() ) { ?>

<div class="row text-left">

	<div class="col-xs-6 col-md-3 col-lg-3"><?php dynamic_sidebar( 'sidebar-left' ); ?></div>
	<div class="col-xs-6 col-md-3 col-lg-3"><?php dynamic_sidebar( 'sidebar-middle-left' ); ?></div>
	<div class="col-xs-6 col-md-3 col-lg-3"><?php dynamic_sidebar( 'sidebar-middle-right' ); ?></div>
	<div class="col-xs-6 col-md-3 col-lg-3"><?php dynamic_sidebar( 'sidebar-right' ); ?></div>

</div>
<hr/>

	<?php
}
