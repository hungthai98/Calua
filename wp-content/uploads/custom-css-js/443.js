<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
 
add_filter(‘woocommerce_empty_price_html’, ‘custom_call_for_price’);

function custom_call_for_price() {
return ‘Liên hệ’;
}</script>
<!-- end Simple Custom CSS and JS -->
