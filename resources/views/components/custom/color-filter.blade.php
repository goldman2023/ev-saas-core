<div>
    <span class="mt-6 font-medium text-lg block mb-3">
        Paint: <span class="capitalize font-bold" x-text="selectedColor"></span>
    </span>
    <fieldset>
        <div class="flex items-center space-x-3">
            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'white'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674320822_Emarius34(6).jpg'"
                class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-pink-500">
                <input type="radio" name="color-choice" value="Pink" class="sr-only"
                    aria-labelledby="color-choice-0-label">
                <span id="color-choice-0-label" class="sr-only">Pink</span>
                <span aria-hidden="true"
                    class="h-8 w-8 bg-[#C9C9C9] border border-black border-opacity-10 rounded-full"></span>
            </label>

            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'orange'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674445471_Emarius34(5).jpg';"
                class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-purple-500">
                <input type="radio" name="color-choice" value="Purple" class="sr-only"
                    aria-labelledby="color-choice-1-label">
                <span id="color-choice-1-label" class="sr-only">Purple</span>
                <span aria-hidden="true"
                    class="h-8 w-8 bg-[#F8F5E9] border border-black border-opacity-10 rounded-full">
                </span>
            </label>

            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'blue'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674437328_Emarius34(13).jpg'"
                class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-blue-500">
                <input type="radio" name="color-choice" value="Blue" class="sr-only"
                    aria-labelledby="color-choice-2-label">
                <span id="color-choice-2-label" class="sr-only">Blue</span>
                <span aria-hidden="true"
                    class="h-8 w-8 bg-[#308DF9] border border-black border-opacity-10 rounded-full"></span>
            </label>

            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'red'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674421700_Emarius34(17).jpg'"
                class="-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none ring-green-500">
                <input type="radio" name="color-choice" value="Green" class="sr-only"
                    aria-labelledby="color-choice-3-label">
                <span id="color-choice-3-label" class="sr-only">Green</span>
                <span aria-hidden="true"
                    class="h-8 w-8 bg-[#EB1B1B] border border-black border-opacity-10 rounded-full"></span>
            </label>



        </div>
    </fieldset>
</div>
