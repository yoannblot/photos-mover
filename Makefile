.PHONY: up down install format test-unit test-integration shell clean

IMAGE_NAME := photos-mover
CONTAINER_NAME := photos-mover

up:
	docker build -t $(IMAGE_NAME) .

down:
	docker rm -f $(CONTAINER_NAME) 2>/dev/null || true
	docker rmi $(IMAGE_NAME) 2>/dev/null || true

install:
	docker run --rm -v $(PWD):/app --entrypoint composer $(IMAGE_NAME) install

test-unit:
	docker run --rm -v $(PWD):/app --entrypoint ./vendor/bin/phpunit $(IMAGE_NAME) --testsuite unit

test-integration:
	docker run --rm -v $(PWD):/app --entrypoint ./vendor/bin/phpunit $(IMAGE_NAME) --testsuite integration

shell:
	docker run --rm -it -v $(PWD):/app --entrypoint bash $(IMAGE_NAME)

format:
	docker run --rm -v $(PWD):/app --entrypoint sh $(IMAGE_NAME) -c "vendor/bin/mago lint --fix --potentially-unsafe && vendor/bin/rector && vendor/bin/mago format"

quality:
	docker run --rm -v $(PWD):/app --entrypoint sh $(IMAGE_NAME) -c "vendor/bin/mago analyze"

clean: down
	rm -rf vendor/
	rm -f composer.lock

.DEFAULT_GOAL := help

help:
	@echo "Available commands:"
	@echo "  make up                 - Build Docker image"
	@echo "  make down               - Remove containers and images"
	@echo "  make install            - Install composer dependencies"
	@echo "  make format             - Auto format/refactor code"
	@echo "  make test-unit          - Run unit tests"
	@echo "  make test-integration   - Run integration tests"
	@echo "  make shell              - Open interactive shell in container"
	@echo "  make clean              - Remove everything (images, containers, vendor, locks)"
