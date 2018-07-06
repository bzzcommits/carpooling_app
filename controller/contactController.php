<?php
class contactController extends BaseController {
    public function index() {
        $this->registry->template->show( 'contact' );
    }
};
?>
