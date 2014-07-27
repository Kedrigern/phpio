#!/bin/sh
# Run tests for
# @author Ondrej Profant

dir="test";

if [ -d "$dir" ]; then
cd "$dir";
fi;

php ../vendor/bin/tester -c php.ini .