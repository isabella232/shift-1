FROM ubuntu:trusty

MAINTAINER James Hebden <james@tectonic.com.au>

RUN \
	apt-get update && \
	apt-get install -y software-properties-common && \
  add-apt-repository ppa:nginx/stable && \
	wget -O – http://dl.hhvm.com/conf/hhvm.gpg.key | sudo apt-key add – && \
  echo deb http://dl.hhvm.com/ubuntu trusty main | sudo tee /etc/apt/sources.list.d/hhvm.list && \
  apt-get update && \
	apt-get -y --force-yes dist-upgrade && \
	apt-get install -y --force-yes supervisor nginx hhvm

ADD .docker/nginx.conf /etc/nginx/sites-enabled/default
ADD .docker/supervisord.conf /etc/supervisor/conf.d/default.conf

ADD .  /var/www/

EXPOSE 80

CMD ["/usr/bin/supervisord -c /etc/supervisor/supervisord.conf"]
