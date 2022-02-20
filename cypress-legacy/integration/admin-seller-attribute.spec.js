describe("Admin Seller Attribute Test", () => {
    it("Shows seller attribute page in admin panel", () => {
        cy.visit("/login");

        cy.get('[data-test="email"]').type("team@eim.solutions");

        // {enter} causes the form to submit
        cy.get('[data-test="password"]').type(`123456{enter}`);

        // we should be redirected to /admin
        cy.url().should("include", "/admin");

        // redirect to seller attribute page
        cy.visit("/admin/attributes/sellers");
        cy.url().should("include", "/admin/attributes/sellers");

        // 1. Create dropdown type attribute
        cy.get('[data-test="name"]').type("new dropdown type attribute");
        //select dropdown option
        cy.get('[data-test="select-attr"]')
            .select("dropdown", { force: true })
            .should("have.value", "dropdown");
        // click save button
        cy.get('[data-test="submit"]').click();

        // we should be redirected to /admin/attributes/sellers
        cy.url().should("include", "/admin/attributes/sellers");

        // 2. Create plain_text type attribute
        cy.get('[data-test="name"]').type("new plain_text type attribute");
        //select plain_text option
        cy.get('[data-test="select-attr"]')
            .select("plain_text", { force: true })
            .should("have.value", "plain_text");
        // click save button
        cy.get('[data-test="submit"]').click();

        // we should be redirected to /admin/attributes/sellers
        cy.url().should("include", "/admin/attributes/sellers");

        // 3. Create checkbox type attribute
        cy.get('[data-test="name"]').type("new checkbox type attribute");
        //select checkbox option
        cy.get('[data-test="select-attr"]')
            .select("checkbox", { force: true })
            .should("have.value", "checkbox");
        // click save button
        cy.get('[data-test="submit"]').click();
    });
});
