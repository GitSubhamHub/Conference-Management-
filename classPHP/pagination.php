<?php
$totalpages = intval(floor($totalresult / $limit));
if (fmod($totalresult, $limit)) {
  # code...
  $totalpages++;
}
for ($i = 1; $i <= $totalpages; $i++) {

  echo '<a  href="' . $pageurl . '?page=' . $i . '"class="viewbtn"> ' . $i . ' </a> ';
}
if ($page != 1) {
  # code...
  if ($page > $totalpages) {
    header("Refresh:0, url=$pageurl?page=$totalpages");
  }
  if ($page < 1) {
    header("Refresh:0, url=$pageurl?page=1");
  }
}
