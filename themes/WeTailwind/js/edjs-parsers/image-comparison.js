export default function imageCompareParser(block) {
    let html = `<div class="wysiwyg__image-compare wp-block-icgb-image-compare icgb-compare-block icv icv__icv--horizontal standard" data-hover="false" data-label="false" data-lil="Before" data-ril="After" data-vertical="false">`;
    
    if(block.data.files.length > 0) {
        block.data.files.forEach((item, index) => {
            if(index === 0) {
                html += `<img loading="lazy" 
                    src="${item.file.url}" alt="${item.caption}" class="icv__img icv__img-a" />`;
            }
        });
    }
    
    html += `<div class="icv__wrapper" 
        style="width: calc(49.4196%); height: 50%; transition: all 100ms ease-out 0s;">`;

    if(block.data.files.length > 1) {
        block.data.files.forEach((item, index) => {
            if(index === 1) {
                html += `<img loading="lazy" 
                    src="${item.file.url}" alt="${item.caption}" class="icv__img icv__img-b" />`;
            }
        });
    }
    html += `</div>`;

    // TODO: Fix it up...
    html += `<div class="icv__control" style="width: 50px; left: calc(50.5804% - 25px); transition: all 100ms ease-out 0s;"><div class="icv__control-line" style="width: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.33) 0px 0px 15px;"></div><div class="icv__theme-wrapper"><div class="icv__arrow-wrapper" style="transform: translateX(8px);"><svg height="15" width="15" style="
    transform: 
    scale(1.5)  
    rotateZ(180deg); height: 20px; width: 20px;
    
    
    -webkit-filter: drop-shadow( 0px 3px 5px rgba(0, 0, 0, .33));
    filter: drop-shadow( 0px -3px 5px rgba(0, 0, 0, .33));
    
    " xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 15 15">
    <path fill="#FFFFFF" stroke="#FFFFFF" stroke-linecap="round" stroke-width="0" d="M4.5 1.9L10 7.65l-5.5 5.4"></path>
  </svg></div><div class="icv__arrow-wrapper" style="transform: translateX(-8px);"><svg height="15" width="15" style="
    transform: 
    scale(1.5)  
    rotateZ(0deg); height: 20px; width: 20px;
    
    
    -webkit-filter: drop-shadow( 0px 3px 5px rgba(0, 0, 0, .33));
    filter: drop-shadow( 0px 3px 5px rgba(0, 0, 0, .33));
    
    " xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 15 15">
    <path fill="#FFFFFF" stroke="#FFFFFF" stroke-linecap="round" stroke-width="0" d="M4.5 1.9L10 7.65l-5.5 5.4"></path>
  </svg></div></div><div class="icv__control-line" style="width: 2px; background: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.33) 0px 0px 15px;"></div></div>`;
    
    html += `</div>`;

    return html;
}