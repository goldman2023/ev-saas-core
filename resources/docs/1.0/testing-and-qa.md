# End To End Testing with Cypress

This project uses Cypress E2E Testing approach

---

## Creating Tests

All of the tests should be included in:
``` /cypress/integration/[feature]```

Tests should be writen based on user stories like:
If we are working on comments functionality, we should define following tests:

`User can post comment`

`Guest user can't post comment`

`User can reply to comment`

`Admin can delete comment`


### Example test:
```javascript
describe('Login Test', () => {
  it('Shows login page', () => {
    cy.visit('/');

    cy.get('.mr-3 > .text-reset').click();
    cy.url().should('include', '/login');
  })
})
```


### Running tests


### Usefull Links

* Installing Cypress locally: https://docs.cypress.io/guides/getting-started/installing-cypress

* Writing tests: https://docs.cypress.io/guides/getting-started/testing-your-app#Step-1-Start-your-server

* Tutorial for working with Cypress + Laravel:
  https://laracasts.com/series/whatcha-working-on/episodes/39
