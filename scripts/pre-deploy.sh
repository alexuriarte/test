#!/bin/bash

# Turn on error reporting
set -e

# Clear the remote path for cloning
rm -rf %remote_path%

# Add a value to the custom metric
echo 0 > /var/metric
