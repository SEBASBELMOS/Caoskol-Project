#FROM haproxy:latest
#COPY haproxy.cfg /usr/local/etc/haproxy/haproxy.cfg

FROM haproxy:latest
USER root
RUN mkdir -p /run/haproxy && chown haproxy:haproxy /run/haproxy
USER haproxy
COPY haproxy.cfg /usr/local/etc/haproxy/haproxy.cfg
