# Contributing

First off, thank you for considering contributing to Community Event Manager. It's people like you that make Community Event Manager such a great tool.

When contributing to this repository, please first discuss the change you wish to make via issue or any other method with the owners of this repository before making a change. 

Please note we have a code of conduct, please follow it in all your interactions with the project.

## Your First Contribution

Unsure where to begin contributing to Community Event Manager? 
You can start by looking through the Good First Issue, those are issues which are a specific and simple task and should not require a high amount of lines of code, with a test or two.

While not perfect, number of comments is a reasonable proxy for impact a given change will have.

## Pull Request Process

1. Link your Pull Request to an existing issue by following the template available for your feature/bugfix. Please note that a Pull Request without link to an issue will be refused.
1. Ensure any install or build dependencies are removed before the end of the layer when doing a 
   build.
2. Update the README.md if needed with details of changes to the interface, this includes new environment 
   variables, exposed ports, useful file locations and container parameters.
3. Update the CHANGELOG.md by increasing the version numbers and add details to your feature or bugfix your
   Pull Request would represent. The versioning scheme we use is [SemVer](http://semver.org/).
4. You may merge the Pull Request in once you have the sign-off of two other developers, or if you 
   do not have permission to do that, you may request the second reviewer to merge it for you.
5. Before creating your Pull Request of your work, please ensure the code style is respected by launching php-cs-fixer into the directory of your project

### Code style 

Please note that your work must respect the [PSR-1](https://www.php-fig.org/psr/psr-1/), [PSR-2](https://www.php-fig.org/psr/psr-2/) and [PSR-4](https://www.php-fig.org/psr/psr-4/) Coding Style Guide 

### Writing Units Tests

Your code should be made with some units tests to ensure longetivy and maintainability of your code.

Units test must be created into the directory `tests\` of your project, and must use phpUnit to implement:

In this directory you need to re create the folder tree of your code, and in this directory create a new class which will be {className to test}Test.php, the class name will be `{class_name_to_test}Test` and must Extend TestCase from phpUnit.

Afterwards, the function name can follow two schemes :
- the function you want to test must be of the same name with the prefix `test` and wrote in camlCase. 
  
  Example : `testCalculateTask()` to test the function `calculateTask()`
  
- the testable function must describe with the less amount of words the use case you want to test, the sentence should be on a positive axe, and this sentence will have the prefix `test`

  Example: to test a bad username on the login part, the testable function could be `testLoginFailedWithBadUsername()`. Please note the positive axe, the function should not be `testLoginNotSuccessfulWithBadUsername()` or `testLoginFailedWithoutGoodUsername()`

## Code of Conduct

### Our Pledge

In the interest of fostering an open and welcoming environment, we as
contributors and maintainers pledge to making participation in our project and
our community a harassment-free experience for everyone, regardless of age, body
size, disability, ethnicity, gender identity and expression, level of experience,
nationality, personal appearance, race, religion, or sexual identity and
orientation.

### Our Standards

Examples of behavior that contributes to creating a positive environment
include:

* Using welcoming and inclusive language
* Being respectful of differing viewpoints and experiences
* Gracefully accepting constructive criticism
* Focusing on what is best for the community
* Showing empathy towards other community members

Examples of unacceptable behavior by participants include:

* The use of sexualized language or imagery and unwelcome sexual attention or
advances
* Trolling, insulting/derogatory comments, and personal or political attacks
* Public or private harassment
* Publishing others' private information, such as a physical or electronic
  address, without explicit permission
* Other conduct which could reasonably be considered inappropriate in a
  professional setting

### Our Responsibilities

Project maintainers are responsible for clarifying the standards of acceptable
behavior and are expected to take appropriate and fair corrective action in
response to any instances of unacceptable behavior.

Project maintainers have the right and responsibility to remove, edit, or
reject comments, commits, code, wiki edits, issues, and other contributions
that are not aligned to this Code of Conduct, or to ban temporarily or
permanently any contributor for other behaviors that they deem inappropriate,
threatening, offensive, or harmful.

### Scope

This Code of Conduct applies both within project spaces and in public spaces
when an individual is representing the project or its community. Examples of
representing a project or community include using an official project e-mail
address, posting via an official social media account, or acting as an appointed
representative at an online or offline event. Representation of a project may be
further defined and clarified by project maintainers.

## Enforcement

Instances of abusive, harassing, or otherwise unacceptable behavior may be
reported by creating an issue directly into the project. All
complaints issues will be reviewed and investigated and will result in a response that
is deemed necessary and appropriate to the circumstances.

Project maintainers who do not follow or enforce the Code of Conduct in good
faith may face temporary or permanent repercussions as determined by other
members of the project's leadership.

## Attribution

This Code of Conduct is adapted from the [Contributor Covenant][homepage], version 1.4,
available at https://www.contributor-covenant.org/version/1/4/code-of-conduct.html

[homepage]: https://www.contributor-covenant.org

For answers to common questions about this code of conduct, see
https://www.contributor-covenant.org/faq