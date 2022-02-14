describe("Gallery Document CURD", () => {
    beforeEach(() => {
        cy.visit("/users/login");

        // we should be redirected to /login
        cy.url().should("include", "/users/login");

        cy.get('data-test="email"').type("eim.kasp@gmail.com");

        // {enter} causes the form to submit
        cy.get('data-test="password"').type(`syska007{enter}`);

        // we should be redirected to /documentgallery
        cy.visit("/documentgallery");

        // we should be redirected to /documentgallery
        cy.url().should("include", "/documentgallery");
    });

    it("Create New Gallery", () => {
        // This should be a parent element of form that we are targeting
        const formTarget = "#gallery-form";

        // input gallery name in text field
        cy.get('[data-test="name"]')
            .should("be.visible")
            .type("cypress test gallery 1");

        //// open file dialog to choose gallery images
        cy.get('[data-test="photos"]')
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

        // //// open file dialog to choose thumbnail image
        // cy.get(formTarget + " [name=thumbnail_img]")
        //     .parent()
        //     .click();
        // cy.get("#aizUploaderModal").should("be.visible");
        // // choose file on file dialog
        // cy.get(".aiz-file-box-wrap")
        //     .first()
        //     .should("be.visible")
        //     .click();
        // // file dialog close on user click on add files button
        // cy.get("[data-toggle=aizUploaderAddSelected]")
        //     .should("be.visible")
        //     .click();
        // cy.get("#aizUploaderModal").should("not.be.visible");

        // input gallery description in textarea
        cy.get('[data-test="description"]')
            .should("not.be.visible")
            .type("cypress test gallery 1 description", { force: true });

        cy.get('[data-test="submit"]').click();

        // we should be redirected to /documentgallery
        cy.url().should("include", "/documentgallery");
    });

    it("Create New Document", () => {
        // This should be a parent element of form that we are targeting
        const formTarget = "#document-form";

        // input gallery name in text field
        cy.get('[data-test="name"]')
            .should("be.visible")
            .type("cypress test gallery 1");

        //// open file dialog to choose gallery images
        cy.get('[data-test="photos"]')
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

        // input gallery description in textarea
        cy.get('[data-test="description"]')
            .should("not.be.visible")
            .type("cypress test document 1 description", { force: true });

        cy.get('[data-test="submit"]').click();

        // we should be redirected to /documentgallery
        cy.url().should("include", "/documentgallery");
    });
});
