describe('logged in user as admin, should be able to access all dashboard routes', () => {

    it('Shows dashboard customer pages for admin', () => {
        var test_routes = [
            'my.account.settings',
            'my.purchases.all',
            'settings.payment_methods',
            'settings.staff_settings',
        ];
        cy.login('team@eim.solutions');

        for (let i = 0; i < test_routes.length; i++) {
            cy.visit({
                route: test_routes[i]
            });

            cy.get('body')
                .should('have.class', test_routes[i])
        }
    })

    it('Shows dashboard settings pages for admin', () => {
        var test_routes = [
            'my.account.settings',
            'settings.shop_settings',
            'settings.payment_methods',
            'settings.staff_settings',
        ];
        cy.login('team@eim.solutions');

        for (let i = 0; i < test_routes.length; i++) {
            cy.visit({
                route: test_routes[i]
            });

            cy.get('body')
                .should('have.class', test_routes[i])
        }
    })


    it('Shows dashboard orders pages for admin', () => {
        var test_routes = [
            'order.create',
            'orders.index'
        ];
        cy.login('team@eim.solutions');

        for (let i = 0; i < test_routes.length; i++) {
            cy.visit({
                route: test_routes[i]
            });

            cy.get('body')
                .should('have.class', test_routes[i])
        }
    })

    it('Shows dashboard blog pages for admin', () => {
        var test_routes = [
            'blog.posts.index',
            'blog.post.create'
        ];
        cy.login('team@eim.solutions');

        for (let i = 0; i < test_routes.length; i++) {
            cy.visit({
                route: test_routes[i]
            });

            cy.get('body')
                .should('have.class', test_routes[i])
        }
    })

    it('Shows dashboard page for admin', () => {

        cy.login('team@eim.solutions');

        cy.visit({
            route: 'dashboard'
        });

        cy.get('body')
            .should('have.class', 'dashboard')
    })


    it('Shows dashboard product management pages for admin', () => {
        var test_routes = [
            'products.index',
            'attributes.index',
            'product.create'
        ];
        cy.login('team@eim.solutions');

        for (let i = 0; i < test_routes.length; i++) {
            cy.visit({
                route: test_routes[i]
            });

            cy.get('body')
                .should('have.class', test_routes[i])
        }
    })

    it('Shows planss page for admin', () => {

        var test_routes = [
            'plans.index',
            'plan.create',
        ];
        cy.login('team@eim.solutions');

        for (let i = 0; i < test_routes.length; i++) {
            cy.visit({
                route: test_routes[i]
            });

            cy.get('body')
                .should('have.class', test_routes[i])
        }
    })

    it('Shows categories management pages for admin', () => {


        var test_routes = [
            'categories.index',
            'category.create',
        ];
        cy.login('team@eim.solutions');

        for (let i = 0; i < test_routes.length; i++) {
            cy.visit({
                route: test_routes[i]
            });

            cy.get('body')
                .should('have.class', test_routes[i])
        }
    })

})

