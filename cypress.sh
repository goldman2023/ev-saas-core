./wait-for-it.sh app:9000 -t 120 && \
./wait-for-it.sh nginx:443 -t 60 && \
./wait-for-it.sh db:3333 -t 180 && \
#npx cypress verify && \
#npx cypress run --record
