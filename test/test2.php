<?php
echo time().'<br>';
var_dump(time()-strtotime(date('Y-m-d H:i:s','1353814277')) > 160);