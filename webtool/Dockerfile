
## Start with the official rocker image (lightweight Debian)
FROM rocker/r-base:latest

## Install Java
RUN apt-get update
RUN apt-get install gnupg gnupg1 gnupg2 -y
RUN apt-get install libssl-dev libcurl4-openssl-dev libxml2-dev -y

RUN echo "deb http://ppa.launchpad.net/webupd8team/java/ubuntu trusty main" \
      | tee /etc/apt/sources.list.d/webupd8team-java.list \
    &&  echo "deb-src http://ppa.launchpad.net/webupd8team/java/ubuntu trusty main" \
      | tee -a /etc/apt/sources.list.d/webupd8team-java.list \
    && apt-key adv --keyserver keyserver.ubuntu.com --recv-keys EEA14886 \
    && echo "oracle-java8-installer shared/accepted-oracle-license-v1-1 select true" \
        | /usr/bin/debconf-set-selections \
    && apt-get update \
    && apt-get install -y oracle-java8-installer \
    && update-alternatives --display java \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean \
    && R CMD javareconf

## Install rJava
RUN install2.r --error rJava

## Build WP5

RUN mkdir /src
WORKDIR /src
ADD ../wp5_webtool/ /src/
#RUN ls

# Install packages
RUN chmod 777 install_packages.sh
RUN ls -lah
#RUN Rscript -e 'install.packages("triangle")'
RUN ./install_packages.sh

CMD R -e "options(shiney.port = 8000); options(shiny.host = '0.0.0.0'); shiny::runApp('/src')"
