class Environment {

    constructor() {

        // get the scene container
        this.container = document.querySelector("#threeContainer");

        // create a scene
        this.scene = new THREE.Scene();

        // create the camera
        this.aspectRatio = this.container.clientWidth / this.container.clientHeight;
        this.camera = new THREE.PerspectiveCamera(30, this.aspectRatio, 0.1, 100);

        // create the renderer
        this.renderer = new THREE.WebGLRenderer();

        // stretch the renderer to the container element
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(devicePixelRatio)
        this.renderer.shadowMap.enabled = true;

        // append the renderer to the container
        this.container.appendChild(this.renderer.domElement);

        this.loader = new THREE.TextureLoader();
    }

    render() {
        this.renderer.render(this.scene, this.camera)
    }

    loadRepeatedMap(path, repeatA, repeatB) {
        var map = this.loader.load(path)

        map.wrapS = THREE.RepeatWrapping;
        map.wrapT = THREE.RepeatWrapping;
        map.repeat.set(repeatA, repeatB);

        return map;
    }
}

class Lights {
    constructor(scene) {

        this.centerlight = new THREE.SpotLight(0xffffff, 1.1, 100)
        this.centerlight.position.z = 20;
        this.centerlight.castShadow = true;
        scene.add(this.centerlight)


        this.backLight = new THREE.PointLight(0xffff99, 1, 20)
        this.backLight.position.z = -10;
        this.backLight.position.y = 5;
        this.backLight.castShadow = true;
        scene.add(this.backLight)
    }
}

class BackgroundScene {

    constructor(environment) {
        const wallGeometry = new THREE.BoxGeometry(100, 50, 1, 200, 200);
        const wallMaterial = this.material = new THREE.MeshStandardMaterial(
            {
                map: environment.loadRepeatedMap("../resources/img/textures/wall_base.jpg", 8, 4),
                normalMap: environment.loadRepeatedMap("../resources/img/textures/wall_normal.jpg", 8, 4),
                displacementMap: environment.loadRepeatedMap("../resources/img/textures/wall_height.png", 8, 4),
                roughnessMap: environment.loadRepeatedMap("../resources/img/textures/wall_roughness.jpg", 8, 4),
                aoMap: environment.loadRepeatedMap("../resources/img/textures/wall_ao.jpg", 8, 4),
            })

        this.wallMesh = new THREE.Mesh(wallGeometry, wallMaterial);

        this.wallMesh.castShadow = true;
        this.wallMesh.receiveShadow = true;

        this.wallMesh.position.z = -15;

        environment.scene.add(this.wallMesh);
    }
}

class DisplayPlane {

    constructor(index, environment) {

        this.geometry = new THREE.PlaneGeometry(1.4, 2)
        this.material = new THREE.MeshLambertMaterial(
            {
                map: environment.loader.load("../resources/img/logos/1024-1453.png"),
                transparent: true,
            })

        this.mesh = new THREE.Mesh(this.geometry, this.material)

        this.index = index;
        this.radius = radius;

        this.setPosition();
    }

    setPosition() {

        var positionAngle = this.index * ((2 * Math.PI) / items) + Math.PI / 2;
        var rotationAngle = - 1 * (positionAngle - Math.PI / 2);

        var xPos = this.radius * Math.cos(positionAngle)
        var yPos = this.radius * Math.sin(positionAngle)

        this.mesh.position.x = xPos;
        this.mesh.position.z = yPos;

        this.mesh.rotation.y = rotationAngle;
    }
}

class AnimatedGeometry {
    constructor(scene) {

        this.centralGeometry = new THREE.CylinderGeometry(1, 1, 1, items);
        this.centralMaterial = new THREE.MeshBasicMaterial(
            {
                color: 0xff0000,
                wireframe: true,
                visible: false
            })

        this.centralMesh = new THREE.Mesh(this.centralGeometry, this.centralMaterial);

        scene.add(this.centralMesh)

        this.planes = []
    }

    update(rotationAmount) {
        this.centralMesh.rotation.y += rotationAmount;
    }

    generatePlanes() {

        for (var i = 0; i < items; i++) {
            var plane = new DisplayPlane(i, environment);
            this.planes.push(plane);
            this.centralMesh.add(plane.mesh);
        }
    }
}

const environment = new Environment();
const lights = new Lights(environment.scene);
const background = new BackgroundScene(environment);

const items = 20;
const radius = (items) / 2;

const geometry = new AnimatedGeometry(environment.scene);
geometry.generatePlanes();


var mouse = {
    x: 0,
    y: 0
};


environment.camera.position.z = radius + 4;

var rotationAmount = 0.0003;


function onMouseMove(event) {

    event.preventDefault();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = - (event.clientY / window.innerHeight) * 2 + 1;
    rotationAmount = mouse.x * 0.0005;

    var raycaster = new THREE.Raycaster();
    raycaster.setFromCamera(mouse, environment.camera);
    var intersects = raycaster.intersectObject(geometry.centralMesh, true);

    if (intersects.length > 0) {
        $('body').css('cursor', 'pointer');

    } else {
        $('body').css('cursor', 'default');
    }
}

environment.container.addEventListener("mousemove", onMouseMove, false);


function animate() {
    requestAnimationFrame(animate);
    environment.render();
    geometry.update(rotationAmount);
}

animate();