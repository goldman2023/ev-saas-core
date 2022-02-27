/**
 * Create a new user and log them in.
 *
 * @param {Object} attributes
 *
 * @example cy.login();
 *          cy.login({ name: 'JohnDoe' });
 *          cy.login({ attributes: { name: 'JohnDoe' }, state: 'guest', load: ['comments] });
 */
Cypress.Commands.add('login', (attributes = {}) => {
    cy.viewport('macbook-13') // Set viewport to 550px x 750px

    // Are we using the new object system.
    let requestBody = attributes.attributes || attributes.state || attributes.load ? attributes : { attributes };
    cy.visit({
        route: 'user.login'
    });

    /* Get the header login button on desktop */
    cy.get('[data-test="we-login-header"]')
        .click()

    cy.get('[data-test="we-login-email"]')
        .type('team@eim.solutions')

    cy.get('[data-test="we-login-password"]')
        .type('syska007')

    cy.get('[data-test="we-login-submit"]')
        .click()

        // Cypress.Laravel.currentUser = body;

        Cypress.log({
            name: 'login',
            message: JSON.stringify('login as an admin'),
            consoleProps: () => ({ info: 'login' }),
        });

        cy.wait(1000);
});

Cypress.Commands.add('loginAsSeller', (attributes = {}) => {
    // Are we using the new object system.
    let requestBody = attributes.attributes || attributes.state || attributes.load ? attributes : { attributes };
    cy.visit({
        route: 'home'
    });

    /* Get the header login button on desktop */
    cy.get('[data-test="we-login-header"]')
        .click()

    cy.get('[data-test="we-login-email"]')
        .type('seller@eim.solutions')

    cy.get('[data-test="we-login-password"]')
        .type('123456789')

    cy.get('[data-test="we-login-submit"]')
        .click()

        // Cypress.Laravel.currentUser = body;

        Cypress.log({
            name: 'login',
            message: JSON.stringify('login as seller'),
            consoleProps: () => ({ user: 'login' }),
        });
});

Cypress.Commands.add('loginAsCustomer', (attributes = {}) => {
    // Are we using the new object system.
    let requestBody = attributes.attributes || attributes.state || attributes.load ? attributes : { attributes };
    cy.visit({
        route: 'home'
    });

    /* Get the header login button on desktop */
    cy.get('[data-test="we-login-header"]')
        .click()

    cy.get('[data-test="we-login-email"]')
        .type('customer@eim.solutions')

    cy.get('[data-test="we-login-password"]')
        .type('123456789')

    cy.get('[data-test="we-login-submit"]')
        .click()

        // Cypress.Laravel.currentUser = body;

        Cypress.log({
            name: 'login',
            message: JSON.stringify('login as seller'),
            consoleProps: () => ({ user: 'login' }),
        });
});


/**
 * Logout the current user.
 *
 * @example cy.logout();
 */
Cypress.Commands.add('logout', () => {
    cy.get('[data-test="we-logout-header"]')
    .click()
});


/**
 * Fetch a CSRF token.
 *
 * @example cy.csrfToken();
 */
Cypress.Commands.add('csrfToken', () => {
    return cy
        .request({
            method: 'GET',
            url: '/__cypress__/csrf_token',
            log: false,
        })
        .its('body', { log: false });
});


/**
 * Fetch and store all named routes.
 *
 * @example cy.refreshRoutes();
 */
Cypress.Commands.add('refreshRoutes', () => {
    return cy.csrfToken().then((token) => {
        return cy
            .request({
                method: 'POST',
                url: '/__cypress__/routes',
                body: { _token: token },
                log: false,
            })
            .its('body', { log: false })
            .then((routes) => {
                cy.writeFile('cypress/support/routes.json', routes, {
                    log: false,
                });

                Cypress.Laravel.routes = routes;
            });
    });
});


/**
 * Visit the given URL or route.
 *
 * @example cy.visit('foo/path');
 *          cy.visit({ route: 'home' });
 *          cy.visit({ route: 'team', parameters: { team: 1 } });
 */
Cypress.Commands.overwrite('visit', (originalFn, subject, options) => {
    if (subject.route) {
        return originalFn({
            url: Cypress.Laravel.route(subject.route, subject.parameters || {}),
            method: Cypress.Laravel.routes[subject.route].method[0],
        });
    }

    return originalFn(subject, options);
});


/**
 * Create a new Eloquent factory.
 *
 * @param {String} model
 * @param {Number|null} times
 * @param {Object} attributes
 *
 * @example cy.create('App\\User');
 *          cy.create('App\\User', 2);
 *          cy.create('App\\User', 2, { active: false });
 *          cy.create('App\\User', { active: false });
 *          cy.create('App\\User', 2, { active: false });
 *          cy.create('App\\User', 2, { active: false }, ['profile']);
 *          cy.create('App\\User', 2, { active: false }, ['profile'], ['guest']);
 *          cy.create('App\\User', { active: false }, ['profile']);
 *          cy.create('App\\User', { active: false }, ['profile'], ['guest']);
 *          cy.create('App\\User', ['profile']);
 *          cy.create('App\\User', ['profile'], ['guest']);
 *          cy.create({ model: 'App\\User', state: ['guest'], relations: ['profile'], count: 2 }
 */
Cypress.Commands.add('create', (model, count = 1, attributes = {}, load = [], state = []) => {
    let requestBody = {};

    if (typeof model !== 'object') {
        if (Array.isArray(count)) {
            state = attributes;
            attributes = {};
            load = count;
            count = 1;
        }

        if (typeof count === 'object') {
            state = load;
            load = attributes;
            attributes = count;
            count = 1;
        }

        requestBody = { model, state, attributes, load, count };
    } else {
        requestBody = model;
    }

    return cy
        .csrfToken()
        .then((token) => {
            return cy.request({
                method: 'POST',
                url: '/__cypress__/factory',
                body: { ...requestBody, _token: token },
                log: false,
            });
        })
        .then((response) => {
            Cypress.log({
                name: 'create',
                message: requestBody.model + (requestBody.count > 1 ? ` (${requestBody.count} times)` : ''),
                consoleProps: () => ({ [model]: response.body }),
            });
        })
        .its('body', { log: false });
});


/**
 * Refresh the database state.
 *
 * @param {Object} options
 *
 * @example cy.refreshDatabase();
 *          cy.refreshDatabase({ '--drop-views': true });
 */
Cypress.Commands.add('refreshDatabase', (options = {}) => {
    return cy.artisan('migrate:fresh', options);
});


/**
 * Seed the database.
 *
 * @param {String} seederClass
 *
 * @example cy.seed();
 *          cy.seed('PlansTableSeeder');
 */
Cypress.Commands.add('seed', (seederClass) => {
    return cy.artisan('db:seed', {
        '--class': seederClass,
    });
});


/**
 * Trigger an Artisan command.
 *
 * @param {String} command
 * @param {Object} parameters
 * @param {Object} options
 *
 * @example cy.artisan('cache:clear');
 */
Cypress.Commands.add('artisan', (command, parameters = {}, options = {}) => {
    options = Object.assign({}, { log: true }, options);

    if (options.log) {
        Cypress.log({
            name: 'artisan',
            message: command,
            consoleProps: () => ({ command, parameters }),
        });
    }

    return cy.csrfToken().then((token) => {
        return cy.request({
            method: 'POST',
            url: '/__cypress__/artisan',
            body: { command: command, parameters: parameters, _token: token },
            log: false,
        });
    });
});


/**
 * Execute arbitrary PHP.
 *
 * @param {String} command
 *
 * @example cy.php('2 + 2');
 *          cy.php('App\\User::count()');
 */
Cypress.Commands.add('php', (command) => {
    return cy
        .csrfToken()
        .then((token) => {
            return cy.request({
                method: 'POST',
                url: '/__cypress__/run-php',
                body: { command: command, _token: token },
                log: false,
            });
        })
        .then((response) => {
            Cypress.log({
                name: 'php',
                message: command,
                consoleProps: () => ({ result: response.body.result }),
            });
        })
        .its('body.result', { log: false });
});
