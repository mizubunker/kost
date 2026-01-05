FROM shinsenter/codeigniter4:latest

COPY . /var/www/html

EXPOSE 8080

CMD php spark serve --host=0.0.0.0 --port=8080
