<?php

if (extension_loaded('mysql') or extension_loaded('mysqli')) {
    // Looking good
    echo "hello";
} else {
    echo "sad";
}
