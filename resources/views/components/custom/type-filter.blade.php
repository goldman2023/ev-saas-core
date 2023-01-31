<div>
    <span class="mt-6 font-medium text-lg block mb-3">
        {{ translate('Type') }}: <span class="capitalize font-bold" x-text="selectedColor"></span>
    </span>
    <fieldset>
        <div class="flex flex-wrap items-center gap-3">
            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'lingine'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/cc772c23-0100-43fc-92c2-13eb0ec7507b/1675099069_Screenshot2023-01-30at19.17.23.png'"
                :class="{ 'ring ring-offset-1': (selectedColor === 'lingine')}"

                class="-m-0.5 relative p-0.5 rounded-md flex items-center justify-center cursor-pointer focus:outline-none ring-gray-800">
                <input type="radio" name="color-choice" value="Pink" class="sr-only"
                    aria-labelledby="color-choice-0-label">
                <span id="color-choice-0-label" class="sr-only">Pink</span>
                <span aria-hidden="true"
                style="background: url('https://businesspress.fra1.digitaloceanspaces.com/uploads/cc772c23-0100-43fc-92c2-13eb0ec7507b/1675099069_Screenshot2023-01-30at19.17.23.png'); background-size: cover; background-repeat: no-repeat; background-position: center;"
                    class="md:h-44 md:w-44 w-[50%] bg-[#C9C9C9] border border-black border-opacity-10 rounded-md">
                </span>
            </label>

            <!--
            Active and Checked: "ring ring-offset-1"
            Not Active and Checked: "ring-2"
          -->
            <label
                @click="selectedColor = 'torcine'; mainImage = 'https://businesspress.fra1.digitaloceanspaces.com/uploads/cc772c23-0100-43fc-92c2-13eb0ec7507b/1675099068_Screenshot2023-01-30at19.17.35.png';"
                :class="{ 'ring ring-offset-1': (selectedColor === 'torcine')}"

                class="-m-0.5 relative p-0.5 rounded-md flex items-center justify-center cursor-pointer focus:outline-none ring-gray-800">
                <input type="radio" name="color-choice" value="Purple" class="sr-only"
                    aria-labelledby="color-choice-1-label">
                <span id="color-choice-1-label" class="sr-only">Purple</span>
                <span aria-hidden="true"
                style="background: url('https://businesspress.fra1.digitaloceanspaces.com/uploads/cc772c23-0100-43fc-92c2-13eb0ec7507b/1675099068_Screenshot2023-01-30at19.17.35.png'); background-size: cover; background-repeat: no-repeat; background-position: center;"
                    class="md:h-44 md:w-44 w-24 h-24 bg-[#C9C9C9] border border-black border-opacity-10 rounded-md">
                </span>
            </label>
        </div>
    </fieldset>
</div>
