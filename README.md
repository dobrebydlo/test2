# Test task 2: Dog breed evaluation

The task was to provide a technical solution for the existing project.\
__The project itself is under the NDA__ so there is only the solution part included in this repository.

## Stack
* Laravel 7 with client's own custom modular system
* MySQL 8.0

## Task details
Basically they had a table describing some 30 to 50 dog breeds scored by 12 parameters and a javascript-backed form on the front end sending user input to server as JSON requests.

What I was expected to do is to implement all the necessary functionality in the middle so the site visitors could find a dog breed matching their expectations.

The breed list was expected to be sorted from the best matching to the worst matching one.

### Initial state
1. Model IdealDog describing the breed with a number of parameters having integer values 0..5.
2. User interface written in Vue.js sending user input to IdealDogsController::all() and parsing the response.

### What needed to be done
1. Implement basic filtering functionality: some parameters work as filters, they filter out breeds if not matched exactly
2. Implement basic evaluation functionality: the other parameters increase or decrease the breed's score match.
3. Return the response containing the list of breeds matching the criteria along with the match score ordered by that match score.

### Special conditions
1. The solution must be flexible: make sure each filter/evaluator may be easily fine-tuned in the future and new filters/evaluators can be easily added.
2. There are no special requirements regarding the speed or cost-effectiveness of the solution at this stage. It will go through further refactoring and optimization anyway.

## The solution

### The implementation
I have provided a flexible solution implemented as a service with a number of methods named according to their function and context:
* Method prefix describes its function: either 'filter' or 'evaluate'
* The rest of the name is studly-cased name of the parameter it handles.

This way each filter/evaluator can be easily located and fine-tuned, and the new filters/evaluators can be easily added to the service.

### Obvious flaws
* The solution is way not cost-effective, especially if there would be much more options. In this particular case I knew there is a limited number of breeds in the database and there will never be much more of them there.
* It relies on method name guessing based on user input which is a potentially dangerous technique that should be avoided under normal circumstances. At least there should be a custom Request implementation used for user input validation. However, in this particular case it was considered tolerable as is.

### The solution includes
* Evaluation service itself
* Service provider ensuring the service registered as deferrable
* Model repository
* Controller providing the necessary functionality to existing frontend

## Feedback
* The solution fully met the potential employer's expectations.
* Job offer was made immediately.
