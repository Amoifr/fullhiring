## Vehicle fleet parking management

### Introduction
It's may be the longer test I've made for a job. I've made it when I've got time. Even it was a list of short sessions, it takes times.
After some time past on this, I've just decide to finish it just for me, and not really to apply to the job.
Because in my actual and past job, I had to ask candidate to do some technical tests. But all the test are about discuss, and I not really understand what is expected here.
So the job is done, and I submit it. It might be better, but I cannot spend more time on this.


### Instructions
I've made about one commit by step.
It will be better to make atomic commits but the test it already long to add more overengineering.


### Commands 

1. A command line cli with the following commands:

```shell
./fleet create <userId> 
# became 
php bin/console fulll:fleet:create <userId> 

./fleet register-vehicle <fleetId> <vehiclePlateNumber>
# became
php bin/console fulll:vehicle:register 2 AB-000-01

./fleet localize-vehicle <fleetId> <vehiclePlateNumber> lat lng [alt]
# became
php bin/console fulll:vehicle:localize 2 AB-000-01

```

### Step 3
#### For code quality, you can use some tools : which one and why (in a few words) ?
- I've made a docker to get a stable environment with a PHP8.1
- Installed PHP-CS-FIXER
- Also a PHPStan configured in level 6 (there are still some errors to fix)
- It will be good to complete behat test around the feature used in the command line cli.
- It will be also good to have phpunit test for unit test
- and finally, package all this into a gitlab/github CI/CD pipeline.

#### you can consider to setup a ci/cd process : describe the necessary actions in a few words
- Answer already given above.