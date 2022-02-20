describe("Company Profile", () => {
    beforeEach(() => {
        cy.visit("/login");

        // we should be redirected to /login
        cy.url().should("include", "/login");

        cy.get('[data-test="email"]').type("eim.kasp@gmail.com");

        // {enter} causes the form to submit
        cy.get('[data-test="password"]').type(`syska007{enter}`);

        // we should be redirected to /dashboard
        cy.url().should("include", "/dashboard");

        cy.visit("/sellers");

        // we should be redirected to /documentgallery
        cy.url().should("include", "/sellers");

        // If company card exist, click on it to vist company profile
        cy.get(".card.card-bordered.card-hover-shadow")
            .its("length")
            .then(res => {
                if (res > 0) {
                    const company_card =
                        ".card.card-bordered.card-hover-shadow:first";

                    // click first company card
                    cy.get(company_card)
                        .find("a.text-dark:eq(1)")
                        .should("be.visible")
                        .click();

                    //we should be redirected to /shop/{slug}
                    cy.url().should("include", "/shop");
                }
            });
    });

    it("Contact Form Submission", () => {
        // click contacts tab in company profile page
        cy.get("#projectsTab li:eq(4)")
            .should("be.visible")
            .click();

        //we should be redirected to /shop/{slug}/info/{sub_page}
        cy.url().should("include", "/info/contacts");

        // // This should be a parent element of form that we are targeting
        const formTarget = "#company-contact-form";

        // input contact title name in text field
        cy.get(formTarget + " input[name=title]")
            .should("be.visible")
            .type("contact title");

        // input contact title name in text field
        cy.get(formTarget + " textarea[name=message]")
            .should("be.visible")
            .type("contact message", { force: true });

        cy.get(formTarget + " input[type=submit]")
            .first()
            .click();
    });

    it("Company Gallery Tab In Profile", () => {
        // click contacts tab in company profile page
        cy.get("#projectsTab li:eq(1)")
            .should("be.visible")
            .click();

        //we should be redirected to /shop/{slug}/info/{sub_page}
        cy.url().should("include", "/info/gallery");
    });

    it("Company Attachment Tab In Profile", () => {
        // click contacts tab in company profile page
        cy.get("#projectsTab li:eq(2)")
            .should("be.visible")
            .click();

        //we should be redirected to /shop/{slug}/info/{sub_page}
        cy.url().should("include", "/info/attachments");
    });
});
