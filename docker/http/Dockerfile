FROM nginx:latest

RUN apt-get -y update
RUN apt-get -y install git

RUN groupadd -g 1000 ad
RUN useradd -u 1000 -ms /bin/bash -g ad ad

WORKDIR /app
