<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form class="hidden" id="ajax-form"></form>
<?php if($has_date_range_picker):?>
    <script src="/assets/libs/moment/moment.min.js"></script>
    <script src="/assets/libs/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/assets/js/common/date_range_picker.js"></script>
<?php endif;?>
</body>
</html>