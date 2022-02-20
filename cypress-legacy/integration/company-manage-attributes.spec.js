describe("Managing Attributes as a company", () => {
    it("Shows seller attribute page in admin panel", () => {
        cy.visit("/users/login");

        cy.get('[data-test="email"]').type("seller@eim.solutions");

        // {enter} causes the form to submit
        cy.get('[data-test="password"]').type(`123456{enter}`);

        // we should be redirected to /admin
        cy.url().should("include", "/dashboard");

        // redirect to seller attribute page
        cy.visit("/attributes");
        cy.url().should("include", "/attributes");

        cy.get("input[type=text]")
            .first()
            .type("new plain text attribute");
        //select country
        cy.get("select[data-placeholder='Choose Country ...']")
            .first()
            .select("United States", { force: true })
            .should("have.value", "US");

        //check checkbox
        cy.get(".aiz-square-check")
            .first()
            .click();

        //check checkbox
        cy.get(".aiz-square-check")
            .last()
            .click();

        //click update attributes button
        cy.get('[data-test="submit"]').click();

        cy.url().should("include", "/attributes");
    });
});
