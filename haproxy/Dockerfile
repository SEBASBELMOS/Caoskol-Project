"FROM haproxy:latest
COPY haproxy.cfg /usr/local/etc/haproxy/haproxy.cfg"

FROM haproxy:latest
RUN mkdir -p /run/haproxy && chown haproxy:haproxy /run/haproxy
COPY haproxy.cfg /usr/local/etc/haproxy/haproxy.cfg
