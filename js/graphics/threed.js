class Environment {

    constructor() {

        // get the scene container
        this.container = document.querySelector("#threeCanvas");

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
        this.centerlight.position.z = 30;
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
        const wallGeometry = new THREE.BoxGeometry(200, 100, 1, 200, 200);
        const wallMaterial = this.material = new THREE.MeshStandardMaterial(
            {
                map: environment.loadRepeatedMap("resources/img/textures/wall_base.jpg", 8, 4),
                normalMap: environment.loadRepeatedMap("resources/img/textures/wall_normal.jpg", 8, 4),
                displacementMap: environment.loadRepeatedMap("resources/img/textures/wall_height.png", 8, 4),
                roughnessMap: environment.loadRepeatedMap("resources/img/textures/wall_roughness.jpg", 8, 4),
                aoMap: environment.loadRepeatedMap("resources/img/textures/wall_ao.jpg", 8, 4),
            })

        this.wallMesh = new THREE.Mesh(wallGeometry, wallMaterial);

        this.wallMesh.castShadow = true;
        this.wallMesh.receiveShadow = true;

        this.wallMesh.position.z = -15;

        environment.scene.add(this.wallMesh);
    }
}

class DisplayPlane {

    constructor(data, index, environment) {

        this.geometry = new THREE.PlaneGeometry(1.4, 2)
        this.material = new THREE.MeshLambertMaterial(
            {
                map: environment.loader.load("resources/" + data.tr_convention_icon),
                transparent: true,
            })

        this.mesh = new THREE.Mesh(this.geometry, this.material)

        this.index = index

        this.mesh.userData = {
            index: data.tr_convention_id,
            name: data.tr_convention_name
        };

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
            var plane = new DisplayPlane(window.data[i], i, environment);
            this.planes.push(plane);
            this.centralMesh.add(plane.mesh);
        }
    }
}

class InteractionCheck {

    constructor() {
        this.delta = 2;

        this.mouse = {
            x: 0,
            y: 0,
        }

        this.initialMouse = {
            x: 0,
            y: 0,
        }

        this.mouseFromCenter = {
            x: 0,
            y: 0,
        }
    }

    updateInitialMouse(event) {
        this.initialMouse.x = (event.clientX - (window.innerWidth / 2));
        this.initialMouse.y = (event.clientY - (window.innerHeight / 2));
    }

    updateMouse(event) {
        this.mouse.x = (event.clientX - (window.innerWidth / 2));
        this.mouse.y = (event.clientY - (window.innerHeight / 2));

        this.mouseFromCenter.x = this.mouse.x / (window.innerWidth / 2);
        this.mouseFromCenter.y = this.mouse.y / (window.innerHeight / 2);
    }

    deltaX() {
        return this.initialMouse.x - this.mouse.x;
    }

    deltaY() {
        return this.initialMouse.y - this.mouse.y;
    }

    hasMoved() {
        return (Math.abs(this.deltaX()) > this.delta || Math.abs(this.deltaY()) > this.delta)
    }
}

class RotationHandler {
    constructor() {

        this.maxRotationAmount = 0.0003;
        this.currentRotationAmount = 0.0003;

        this.moveHandlerPresent = true;

        this.friction = 0.001;

        this.timeStamp = Date.now();
    }

    updateRotationAmount() {
        if (Math.abs(this.currentRotationAmount) > this.maxRotationAmount) {

            if (this.currentRotationAmount < 0) {
                this.currentRotationAmount += this.friction;
            }
            if (this.currentRotationAmount > 0) {
                this.currentRotationAmount -= this.friction;
            }
        }
    }

    updateEventHandlers() {
        if (Math.abs(this.currentRotationAmount) < this.maxRotationAmount) {
            if (!this.moveHandlerPresent) {
                environment.container.addEventListener("mousemove", onMouseMove, false);
                this.moveHandlerPresent = true;
            }

        }
    }
}

const environment = new Environment();
const lights = new Lights(environment.scene);
const background = new BackgroundScene(environment);

const items = window.data.length;
const radius = items / 2;

const geometry = new AnimatedGeometry(environment.scene);
const interactions = new InteractionCheck();

const rotation = new RotationHandler();

geometry.generatePlanes();

environment.camera.position.z = radius + 4;


// EVENTS

// default mouse move function when no click is made
function onMouseMove(event) {

    interactions.updateMouse(event)

    rotation.currentRotationAmount = interactions.mouseFromCenter.x * rotation.maxRotationAmount;

    var raycaster = new THREE.Raycaster();

    raycaster.setFromCamera(interactions.mouseFromCenter, environment.camera);

    var intersects = raycaster.intersectObject(geometry.centralMesh, true);

    if (intersects.length > 0) {
        $('body').css('cursor', 'pointer');
        $('#shieldhover').text(intersects[0].object.userData.name);
        $('#shieldhoverwrap').css("background", "var(--info-bg)")

    } else {
        $('body').css('cursor', 'default');
        $('#shieldhover').text("");
        $('#shieldhoverwrap').css("background", "transparent")
    }
}

// function to drag the elements
function onMouseDrag(event) {

    interactions.updateMouse(event);

    var angle = - interactions.deltaX() * 0.000004;

    geometry.centralMesh.rotation.y += angle;

}

// main on mouse down function
function onMouseDown(event) {

    interactions.updateInitialMouse(event);
    interactions.updateMouse(event)

    // remove default mouse move handler
    environment.container.removeEventListener("mousemove", onMouseMove, false);
    rotation.moveHandlerPresent = false;

    rotation.currentRotationAmount = 0;

    // add drag handler
    environment.container.addEventListener("mousemove", onMouseDrag, false);

    // add mouseup handler
    environment.container.addEventListener("mouseup", onMouseUp, false);
}

function onMouseUp(event) {

    environment.container.removeEventListener("mousemove", onMouseDrag, false);

    interactions.updateMouse(event)

    if (!interactions.hasMoved()) {
        var raycaster = new THREE.Raycaster();

        raycaster.setFromCamera(interactions.mouseFromCenter, environment.camera);

        var intersects = raycaster.intersectObject(geometry.centralMesh, true);

        if (intersects.length > 0) {
            console.log("Clicked: ")
            console.log(intersects[0].object.userData)
        }
    }

    else {
        rotation.currentRotationAmount = rotation.maxRotationAmount * 5;
    }
}


// environment.container.addEventListener("mousedown", interactions.onMouseDown, false);
environment.container.addEventListener("mousemove", onMouseMove, false);
environment.container.addEventListener("mousedown", onMouseDown, false);


function animate() {
    requestAnimationFrame(animate);
    environment.render();
    rotation.updateRotationAmount();
    rotation.updateEventHandlers();

    if (rotation.moveHandlerPresent) {
        geometry.update(rotation.currentRotationAmount);
    }

}

animate();