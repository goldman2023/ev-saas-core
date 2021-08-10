describe("Admin Seller Attribute Test", () => {
    it("Shows seller attribute page in admin panel", () => {
        cy.visit("/login");

        cy.get('[data-test="email"]').type("team@eim.solutions");

        // {enter} causes the form to submit
        cy.get('[data-test="password"]').type(`123456{enter}`);

        // we should be redirected to /admin
        cy.url().should("include", "/admin");

        // redirect to seller attribute page
        cy.visit("/shop/Demo-Seller-Shop-1/review/create");
        cy.url().should("include", "/shop/Demo-Seller-Shop-1/review/create");

        // 1. Select a star rating
        cy.get(".las.la-star")
            .last()
            .click();

        // 2. Input comment
        cy.get('[data-test="comment"]').type("5 star review for cypress");

        // click save button
        cy.get("button[type=submit]").click();

        // It should be redirected to /shop/Demo-Seller-Shop-1/info/reviews
        cy.url().should("include", "/shop/Demo-Seller-Shop-1/info/reviews");
    });
});
