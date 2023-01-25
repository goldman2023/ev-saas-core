<div>
    <span class="mt-6 font-medium text-lg block mb-3">
        Paint: <span class="capitalize font-bold" x-text="selectedColor"></span>
    </span>
    <fieldset>
        <div class="flex flex-wrap items-center gap-3">
            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'nardo gray'; mainImage = 'https://images.we-saas.com/insecure/fill/1400/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674320822_Emarius34(6).jpg@webp'"
                :class="{ 'ring ring-offset-1': (selectedColor === 'nardo gray')}"

                class="-m-0.5 relative p-0.5 rounded-md flex items-center justify-center cursor-pointer focus:outline-none ring-gray-800">
                <input type="radio" name="color-choice" value="Pink" class="sr-only"
                    aria-labelledby="color-choice-0-label">
                <span id="color-choice-0-label" class="sr-only">Pink</span>
                <span aria-hidden="true"
                style="background: url('https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674462278_emarius-gray.png@webp?ver=1674462361137'); background-size: contain; background-repeat: no-repeat; background-position: center;"
                    class="h-28 w-28 bg-[#C9C9C9] border border-black border-opacity-10 rounded-md">
                </span>
            </label>

            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'pearl white'; mainImage = 'https://images.we-saas.com/insecure/fill/1400/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674462949_Emarius34(4).jpg@webp?ver=1674462953079';"
                :class="{ 'ring ring-offset-1': (selectedColor === 'pearl white')}"

                class="-m-0.5 relative p-0.5 rounded-md flex items-center justify-center cursor-pointer focus:outline-none ring-gray-800">
                <input type="radio" name="color-choice" value="Purple" class="sr-only"
                    aria-labelledby="color-choice-1-label">
                <span id="color-choice-1-label" class="sr-only">Purple</span>
                <span aria-hidden="true"
                style="background: url('https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674462277_emarius-white.png@webp?ver=1674462290814'); background-size: contain; background-repeat: no-repeat; background-position: center;"
                    class="h-28 w-28 bg-[#C9C9C9] border border-black border-opacity-10 rounded-md">
                </span>
            </label>

            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'orange'; mainImage = 'https://images.we-saas.com/insecure/fill/1500/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674445471_Emarius34(5).jpg@webp?ver=1674462823234'"
                :class="{ 'ring ring-offset-1': (selectedColor === 'orange')}"
                class="-m-0.5 relative p-0.5 rounded-md flex items-center justify-center cursor-pointer focus:outline-none ring-orange-700">
                <input type="radio" name="color-choice" value="Blue" class="sr-only"
                    aria-labelledby="color-choice-2-label">
                <span id="color-choice-2-label" class="sr-only">Blue</span>
                <span aria-hidden="true"
                style="background: url('https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674462278_emarius-orange.png@webp?ver=1674462346866'); background-size: contain; background-repeat: no-repeat; background-position: center;"
                    class="h-28 w-28 bg-[#C9C9C9] border border-black border-opacity-10 rounded-md">
                </span>
            </label>

            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'blue'; mainImage = 'https://images.we-saas.com/insecure/fill/1400/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674437328_Emarius34(13).jpg@webp?ver=1674462864291'"
                :class="{ 'ring ring-offset-1': (selectedColor === 'blue')}"

                style="margin-left: 0;"
                class="-m-0.5 relative p-0.5 rounded-md flex items-center justify-center cursor-pointer focus:outline-none ring-blue-700">
                <input type="radio" name="color-choice" value="Green" class="sr-only"
                    aria-labelledby="color-choice-3-label">
                <span id="color-choice-3-label" class="sr-only">Green</span>
                <span aria-hidden="true"
                style="background: url('https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674462278_emarius-blue.png@webp?ver=1674462419733'); background-size: contain; background-repeat: no-repeat; background-position: center;"
                    class="h-28 w-28 bg-[#C9C9C9] border border-black border-opacity-10 rounded-md">
                </span>
            </label>

            <label
                @click="selectedColor = 'red'; mainImage = 'https://images.we-saas.com/insecure/fill/1200/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674421700_Emarius34(17).jpg@webp?ver=1674463000518'"
                :class="{ 'ring ring-offset-1': (selectedColor === 'red')}"
                class="-m-0.5 relative p-0.5 rounded-md flex items-center justify-center cursor-pointer focus:outline-none ring-red-700">
                <input type="radio" name="color-choice" value="Green" class="sr-only"
                    aria-labelledby="color-choice-3-label">
                <span id="color-choice-3-label" class="sr-only">Green</span>
                <span aria-hidden="true"
                style="background: url('https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://businesspress.fra1.digitaloceanspaces.com/uploads/993c7c75-52ff-42ea-9cb6-c149fa874601/1674462277_emarius-red.png@webp?ver=1674462328359'); background-size: contain; background-repeat: no-repeat; background-position: center;"
                    class="h-28 w-28 bg-[#C9C9C9] border border-black border-opacity-10 rounded-md">
                </span>
            </label>



        </div>
    </fieldset>
</div>
