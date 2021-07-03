<?php
/**
 * Standard includes
 */
global $smarty, $zfsession;


/* Display the template */	
$smarty->display($zfsession->domainData['smartypath'].'/includes/footer.tpl');
?>

