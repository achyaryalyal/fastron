#!/bin/bash

bucket_size="$(s5cmd --endpoint-url http://s3-id-jkt-1.kilatstorage.id/ du --humanize s3://bbg-master-cabinet/* && s5cmd --endpoint-url http://s3-id-jkt-1.kilatstorage.id/ du --humanize s3://bbg-development-cabinet/*)"

echo -e "$bucket_size"
