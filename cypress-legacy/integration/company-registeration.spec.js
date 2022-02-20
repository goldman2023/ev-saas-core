describe("Company Registeration Test", () => {
    it("Form Validation Test before login", () => {
        cy.visit("/shops/create");
        // click save button
        cy.get('[data-test="submit"]').click();

        // uncorrect password case validation
        cy.get('[data-test="company_name"]').type("Test Company");

        // type the Address
        cy.get('[data-test="address"]').type("Test address");

        //select dropdown attribute
        cy.get('[data-test="country"]').select("AL", { force: true });

        // Type the name
        cy.get('[data-test="name"]').type("Test Company");

        // type the email
        cy.get('[data-test="form-email"]').type("team@eim.solutions");

        // type the phone_number
        cy.get('[data-test="phone_number"]').type("14242434305");

        // Type the password
        cy.get('[data-test="password"]').type("testpassword");

        // Type the confirm password
        cy.get('[data-test="password_confirmation"]').type("testpassword1");

        // Submit action
        cy.get('[data-test="submit"]').click();

        // correct registeration
        cy.get('[data-test="password"]').type("testpassword");

        // Type the confirm password
        cy.get('[data-test="password_confirmation"]').type("testpassword");

        // Submit action
        cy.get('[data-test="submit"]').click();
    });

    it("Form Validation Test after login", () => {
        cy.visit("/users/login");

        cy.get('data-test="email"').type("eim.kasp@gmail.com");

        // {enter} causes the form to submit
        cy.get('data-test="password"').type(`syska007{enter}`);

        // we should be redirected to /admin
        cy.visit("/shops/create");
        cy.url().should("include", "/shops/create");

        // click save button
        cy.get('data-test="submit"')
            .first()
            .click();

        // Correct Registeration Validation
        cy.get('data-test="company_name"').type("Test Company");

        // Type address
        cy.get('data-test="address"').type("Test Company Adress");

        cy.get('data-test="submit"').click();
    });
});
