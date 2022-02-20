describe("Event Test on seller side", () => {
    it("Login and redirect to event page", () => {
        cy.visit("/users/login");

        cy.get('[data-test="email"]').type("seller@eim.solutions");

        // {enter} causes the form to submit
        cy.get('[data-test="password"]').type(`123456{enter}`);

        // we should be redirected to /seller/events
        cy.visit("/seller/events");
        cy.url().should("include", "/seller/events");
        // Crate new event
        cy.visit("/seller/events/upload");

        // // Form Validation for event
        cy.get('[data-test="submit"]').click();

        // Input title and description
        cy.get('[data-test="title"]').type("B2B Wood Party");

        cy.get('[data-test="description"]').type("This is our first description");

        // open file dialog to choose gallery images
        cy.get('[data-test="image"]').click();

        cy.get('[data-test="aizUploaderModal"]').should("be.visible");

        // choose files on file dialog
        cy.get('.aiz-file-box-wrap')
            .first()
            .should("be.visible")
            .click();
        cy.get('.aiz-file-box-wrap')
            .eq(1)
            .should("be.visible")
            .click();
        cy.get('[data-test="imageAddFile"]').click();

        cy.get('[data-test="submit"]').click();

        cy.visit("/seller/events");
        cy.url().should("include", "/seller/events");

        // Detail page view
        cy.get('[data-test="detail-view"]').first().click({force: true});

        // we should be redirected to /seller/evvents
        cy.visit("/seller/events");
        cy.url().should("include", "/seller/events");

        // Edit Event Test
        cy.get('[data-test="editItem"]')
            .first()
            .should("be.visible")
            .click();

        cy.get('[data-test="title"]').type("B2B Wood Party change");

        cy.get('[data-test="description"]').type(
            "This is our first description changed"
        );

        cy.get('[data-test="event-type"]')
            .first()
            .select("Online", {
                force: true
            });

        cy.get('[data-test="price"]')
            .first()
            .type("59.95");

        cy.get('[data-test="start-date"]').type("08-10-2021 10:15", {force: true});
        cy.get('[data-test="end-date"]').type("08-10-2021 14:30", {force: true});

        cy.get('[data-test="location-country"]').select(
            "Serbia",
            {
                force: true
            }
        );
        cy.get('[data-test="submit"]')
            .first()
            .click();

        // Delete Test
        cy.get('[data-test="deleteItem"]').last().click();
        cy.get('[data-test="deleteSubmit"]').click();
    });
});
