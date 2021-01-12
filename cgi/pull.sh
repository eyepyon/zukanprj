#!/bin/sh

### /home/sites/www.zukan.cloud/wwwroot/zukanprj

### /home/sites/www.zukan.cloud/wwwroot/zukanprj/cgi/pull.sh
### */1 * * * * /home/sites/www.zukan.cloud/wwwroot/zukanprj/cgi/pull.sh 1>/dev/null

cd $(cd $(dirname $0)/../;pwd)
git pull
