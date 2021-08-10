// early-bird.spec.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test

describe("EarlyBird Campaign", () => {
    beforeEach(() => {
        cy.visit("/early-bird/");
    });
    /* Tests should Cover all the user stories provided in user stories for specific feature */
    it("Page Loads!", () => {
        cy.contains(
            "[data-test=landing-heading]",
            "BECOME A PART OF SOMETHING SPECIAL"
        );
    });

    it("Top Signup Form Works", () => {
        cy.visit("/early-bird/");
        const button = cy.get("#early-bird-submit");

        // This should be a parent element of form that we are targeting
        const formTarget = "#hero-form ";

        cy.get('[data-test="name"]')
            .should("be.visible")
            .type("John Doe");

        cy.get('[data-test="email"]')
            .should("be.visible")
            .type("testing@b2bwood.com");
        cy.get('[data-test="company"]')
            .should("be.visible")
            .type("B2BWood Test");

        cy.get('[data-test="phone"]')
            .should("be.visible")
            .type("+3704442211");

        cy.get('[data-test="submit"]')
            .should("be.visible")
            .click();

        cy.get('[data-test="form-notification"]').should("be.visible");
    });

    it("Bottom Signup Form Works", () => {
        cy.visit("/early-bird/");

        // This should be a parent element of form that we are targeting
        const formTarget = "#footer-form ";

        cy.get('[data-test="name"]')
            .should("be.visible")
            .type("John Doe");

        cy.get('[data-test="email"]')
            .should("be.visible")
            .type("testing@b2bwood.com");
        cy.get('[data-test="company"]')
            .should("be.visible")
            .type("B2BWood Test");

        cy.get('[data-test="phone"]')
            .should("be.visible")
            .type("+3704442211");

        cy.get('[data-test="submit"]')
            .should("be.visible")
            .click();

        cy.get('[data-test="form-notification"]').should("be.visible");
    });

    it("Validates Email Field", () => {
        /** We should accept only valid emails according to RFCValidation standard also we can check agains this:
        DNSCheckValidation, documentation refference: https://laravel.com/docs/8.x/validation#rule-email
        */
    });

    it("Page is scrollable", () => {
        // will move on to next command even if table is not scrollable
        cy.get("body").scrollTo("bottom", { ensureScrollable: false });
        cy.get("footer").should("be.visible");
    });

    it("Shows login page", () => {
        cy.visit("/");

        cy.get(".mr-3 > .text-reset").click();
        cy.url().should("include", "/login");
    });
});
