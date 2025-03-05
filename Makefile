# import ENV
#cnf ?= .env
#include $(cnf)
#export $(shell sed 's/=.*//' $(cnf))

# grep the version from the mix file
#VERSION=$(shell ./version.sh)

# HELP
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
.PHONY: help horizon reverb schedule

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

horizon: ## Run horizon service
	./vendor/bin/sail artisan horizon

reverb: ## Run reverb server
	./vendor/bin/sail artisan reverb:start --debug

schedule: ## Run scheduler locally
	./vendor/bin/sail artisan schedule:work

dev: ## npm run dev
	./vendor/bin/sail npm run dev

build: ## npm run build
	./vendor/bin/sail npm run build
