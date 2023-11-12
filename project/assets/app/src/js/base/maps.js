export default function maps() {
    const mapWrapper = document.getElementById('map')
    if (mapWrapper) {
        if (typeof ymaps === 'object') {
            ymaps.ready(function () {
                const iconPath = mapWrapper.dataset.icon;
                const coords = mapWrapper.dataset.coords.split(',');
                coords[0] = Number(coords[0]) - 0.002;

                const map = new ymaps.Map("map", {
                    center: coords,
                    controls: [],
                    zoom: 15
                });

                map.behaviors.disable('scrollZoom')
                window.innerWidth < 1024 && map.behaviors.disable('drag')
                map.controls.add('zoomControl', {
                    size: "small",
                    position: {
                        top: mapWrapper.offsetHeight / 2 - 61 / 2,
                        right: 10,
                        left: 'auto'
                    }
                });

                const address = new ymaps.Placemark(
                    mapWrapper.dataset.coords.split(','),
                    {},
                    {
                        iconLayout: "default#image",
                        iconImageHref: iconPath,
                        iconImageSize: [50, 50]
                    }
                )

                map.geoObjects.add(address);
            });
        }
    }
}