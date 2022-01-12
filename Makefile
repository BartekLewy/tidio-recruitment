build:
	docker-compose build && \
	docker-compose up -d && \
	docker exec -i payroll_db mysql -uroot -proot payroll < .docker/mysql/schema.sql && \
	docker exec -i payroll_php composer install

app:
	docker-compose up -d

stop:
	docker-compose stop

down:
	docker-compose down

test:
	docker exec -it payroll_php php bin/phpunit