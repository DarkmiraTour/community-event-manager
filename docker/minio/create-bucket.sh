#!/bin/sh

export $(grep -v '^#' .env | xargs)

/usr/bin/mc config host add minio http://storage:9000 ${S3_KEY} ${S3_SECRET};
/usr/bin/mc rm -r --force minio/events;
/usr/bin/mc mb minio/events;
/usr/bin/mc policy download minio/events;
