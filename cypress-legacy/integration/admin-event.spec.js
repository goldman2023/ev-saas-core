describe("Event Test", () => {
    it("Admin side test", () => {
        cy.visit("/login");

        cy.get('[data-test="email"]').type("team@eim.solutions");

        // {enter} causes the form to submit
        cy.get('[data-test="password"]').type(`123456{enter}`);

        // we should be redirected to /admin
        cy.url().should("include", "/admin");

        // redirect to event page
        cy.visit("/admin/events");

        // redirect to event page
        cy.visit("/admin/events/create");

        // Input title and description
        cy.get('[data-test="title"]').type("B2B Wood Party");

        cy.get('[data-test="description"]').type("This is our first description");

        // open file dialog to choose gallery images
        cy.get('[data-test="image"]')
            .parent()
            .click();

        cy.get('[data-test="aizUploaderModal"]').should("be.visible");
        // choose files on file dialog
        cy.get('[data-test="aiz-file-box-wrap"]')
            .first()
            .should("be.visible")
            .click();
        cy.get('[data-test="aiz-file-box-wrap"]')
            .eq(1)
            .should("be.visible")
            .click();
        cy.get('[data-test="imageAddFile"]').click();
        cy.get('[data-test="Submit"]').click();

        // Edit Event Test

        cy.get('[data-test="editItem"]')
            .first()
            .click();
        cy.get('[data-test="confirm-delete"]')
            .first()
            .parent()
            .first()
            .click();

        cy.get('[data-test="title"]').type("B2B Wood Party change");

        cy.get('[data-test="description"]').type(
            "This is our first description changed"
        );

        cy.get("select")
            .first()
            .select("Online", { force: true });
        cy.get("input[type=number]")
            .first()
            .type("8999");
        cy.get("input[aria-describedby='date_range']").type("08-10-2021 00:00");
        cy.get("select[data-placeholder='Choose Country ...']").select(
            "Albania",
            {
                force: true
            }
        );
        cy.get("#plain_text_19")
            .last()
            .type("Long Beach, water park, California");

        cy.get('[data-test="submit"]')
            .first()
            .click();

        // Delete Event Test
        cy.get('[data-test="deleteItem"]').click();

        cy.get('[data-test="confirm-delete"]')
            .first()
            .click();
        cy.get('[data-test="delete-link"]').click();
    });

    it("Home side Events listing and filtering test", () => {
        // visit events listing page
        cy.visit("/events");

        // fitering with date and country for example
        cy.visit(
            "events?attribute_53=LT&attribute_54=15-06-2021+00%3A00+to+17-11-2021+00%3A00&attribute_55%5B%5D=&attribute_55%5B%5D=&attribute_56="
        );
    });
});
