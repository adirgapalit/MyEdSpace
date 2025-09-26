# MyEdSpace

Step to run the project:

1. Pull _git@github.com:adirgapalit/MyEdSpace.git_
2. Before run the project please run composer install 
3. When everything setup run php run.php to see how the project works. The scenario following this expected behavior:
   **Expected Behaviour**
         1. On 01/05/2025, Emma tries to access Prep Material → ❌ Denied (course not
            started)
         2. On 13/05/2025, she accesses Prep Material → ✅ Allowed
         3. On 15/05/2025 at 10:01, she accesses the Lesson → ✅ Allowed
         4. On 20/05/2025, an external system shortens Emma’s enrolment → new end
            date is 20/05/2025
         5. On 21/05/2025, she tries to access Homework → ❌ Denied (enrolment
            expired early)
         6. On 30/05/2025, she tries again → ❌ Denied
         7. On 10/06/2025, the course is still running, but Emma is no longer enrolled →
            ❌ Denied
4. To run the test please run:  _./vendor/bin/phpunit --testdox tests/AccessControlServiceTest.php_