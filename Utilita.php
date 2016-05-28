<?php

// Converti le lettere accentate
function html($string) {
    return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
}
