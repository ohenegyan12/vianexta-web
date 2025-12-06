// import Events from 'threesixty/events.js';
class Events {
  #dragOrigin = null;
  #options = null;

  #eventHandlers = null;

  constructor(threesixty, options) {
    this.#options = options;

    this.#eventHandlers = {
      container: {
        mousedown: (e) => this.#dragOrigin = e.pageX,
        touchstart: (e) => this.#dragOrigin = e.touches[0].clientX,
        touchend: () => this.#dragOrigin = null,
      },
      prev: {
        mousedown: (e) => {
          e.preventDefault();
          threesixty.play(true);
        },
        mouseup: (e) => {
          e.preventDefault();
          threesixty.stop();
        },
        touchstart: (e) => {
          e.preventDefault();
          threesixty.prev();
        }
      },
      next: {
        mousedown: (e) => {
          e.preventDefault();
          threesixty.play();
        },
        mouseup: (e) => {
          e.preventDefault();
          threesixty.stop();
        },
        touchstart: (e) => {
          e.preventDefault();
          threesixty.next();
        }
      },
      global: {
        mouseup: () => this.#dragOrigin = null,
        mousemove: (e) => {
          if (this.#dragOrigin && Math.abs(this.#dragOrigin - e.pageX) > this.#options.dragTolerance) {
            threesixty.stop();
            this.#dragOrigin > e.pageX ? threesixty.prev() : threesixty.next();
            this.#dragOrigin = e.pageX;
          }
        },
        touchmove: (e) => {
          if (this.#dragOrigin && Math.abs(this.#dragOrigin - e.touches[0].clientX) > this.#options.swipeTolerance) {
            threesixty.stop();
            this.#dragOrigin > e.touches[0].clientX ? threesixty.prev() : threesixty.next();
            this.#dragOrigin = e.touches[0].clientX;
          }
        },
        keydown: (e) => {
          if ([37, 39].includes(e.keyCode)) {
            threesixty.play(37 === e.keyCode);
          }
        },
        keyup: (e) => {
          if ([37, 39].includes(e.keyCode)) {
            threesixty.stop();
          }
        }
      }
    };

    this._initEvents();
  }

  destroy() {
    this.#options.swipeTarget.removeEventListener('mousedown', this.#eventHandlers.container.mousedown);
    this.#options.swipeTarget.removeEventListener('touchstart', this.#eventHandlers.container.touchstart);
    this.#options.swipeTarget.removeEventListener('touchend', this.#eventHandlers.container.touchend);

    window.removeEventListener('mouseup', this.#eventHandlers.global.mouseup);
    window.removeEventListener('mousemove', this.#eventHandlers.global.mousemove);
    window.removeEventListener('touchmove', this.#eventHandlers.global.touchmove);
    window.removeEventListener('keydown', this.#eventHandlers.global.keydown);
    window.removeEventListener('keyup', this.#eventHandlers.global.keyup);

    if (this.#options.prev) {
      this.#options.prev.removeEventListener('mousedown', this.#eventHandlers.prev.mousedown);
      this.#options.prev.removeEventListener('mouseup', this.#eventHandlers.prev.mouseup);
      this.#options.prev.removeEventListener('touchstart', this.#eventHandlers.prev.touchstart);
    }

    if (this.#options.next) {
      this.#options.next.removeEventListener('mousedown', this.#eventHandlers.next.mousedown);
      this.#options.next.removeEventListener('mouseup', this.#eventHandlers.next.mouseup);
      this.#options.next.removeEventListener('touchstart', this.#eventHandlers.next.touchstart);
    }
  }

  _initEvents() {
    if (this.#options.draggable) {
      this.#options.swipeTarget.addEventListener('mousedown', this.#eventHandlers.container.mousedown);
      window.addEventListener('mouseup', this.#eventHandlers.global.mouseup);
      window.addEventListener('mousemove', this.#eventHandlers.global.mousemove);
    }

    if (this.#options.swipeable) {
      this.#options.swipeTarget.addEventListener('touchstart', this.#eventHandlers.container.touchstart);
      this.#options.swipeTarget.addEventListener('touchend', this.#eventHandlers.container.touchend);
      window.addEventListener('touchmove', this.#eventHandlers.global.touchmove);
    }

    if (this.#options.keys) {
      window.addEventListener('keydown', this.#eventHandlers.global.keydown);
      window.addEventListener('keyup', this.#eventHandlers.global.keyup);
    }

    if (this.#options.prev) {
      this.#options.prev.addEventListener('mousedown', this.#eventHandlers.prev.mousedown);
      this.#options.prev.addEventListener('mouseup', this.#eventHandlers.prev.mouseup);
      this.#options.prev.addEventListener('touchstart', this.#eventHandlers.prev.touchstart);
    }

    if (this.#options.next) {
      this.#options.next.addEventListener('mousedown', this.#eventHandlers.next.mousedown);
      this.#options.next.addEventListener('mouseup', this.#eventHandlers.next.mouseup);
      this.#options.next.addEventListener('touchstart', this.#eventHandlers.next.touchstart);
    }
  }
}

class ThreeSixty {
  #options = null;
  #index = 0;

  #loopTimeoutId = null;
  #looping = false;
  #maxloops = null;

  #events = null;
  #sprite = false;

  constructor(container, options) {
    this.container = container;

    this.#options = Object.assign({
      width: 300,
      height: 300,
      aspectRatio: 0,
      count: 0,
      perRow: 0,
      speed: 100,
      dragTolerance: 10,
      swipeTolerance: 10,
      draggable: true,
      swipeable: true,
      keys: true,
      inverted: false
    }, options);

    this.#options.swipeTarget = this.#options.swipeTarget || this.container;

    this.#sprite = !Array.isArray(this.#options.image);
    if (!this.sprite) {
      this.#options.count = this.#options.image.length;
    }

    Object.freeze(this.#options);

    this.#events = new Events(this, this.#options);

    this._windowResizeListener = this._windowResizeListener.bind(this);

    this._initContainer();

    this.nloops = 0;
  }

  get isResponsive() {
    return this.#options.aspectRatio > 0;
  }

  get containerWidth() {
    return this.isResponsive ? this.container.clientWidth : this.#options.width;
  }

  get containerHeight() {
    return this.isResponsive
      ? this.container.clientWidth * this.#options.aspectRatio
      : this.#options.height;
  }

  get index() {
    return this.#index;
  }

  get looping() {
    return this.#looping;
  }

  get sprite() {
    return this.#sprite;
  }

  next() {
    this.goto(this.#options.inverted ? this.#index - 1 : this.#index + 1);
  }

  prev() {
    this.goto(this.#options.inverted ? this.#index + 1 : this.#index - 1);
  }

  goto(index) {
    this.#index = (this.#options.count + index) % this.#options.count;

    this._update();
  }

  play (reversed, maxloops) {
    if (this.looping) {
      return;
    }

    this._loop(reversed);
    this.#looping = true;
    this.#maxloops = maxloops;
    this.nloops = 0;
  }

  stop () {
    if (!this.looping) {
      return;
    }

    window.clearTimeout(this.#loopTimeoutId);
    this.#looping = false;
    this.#maxloops = null;
    this.nloops = 0;
  }

  toggle(reversed) {
    this.looping ? this.stop() : this.play(reversed);
  }

  destroy() {
    this.stop();

    this.#events.destroy();

    this.container.style.width = '';
    this.container.style.height = '';
    this.container.style.backgroundImage = '';
    this.container.style.backgroundPositionX = '';
    this.container.style.backgroundPositionY = '';
    this.container.style.backgroundSize = '';

    if (this.isResponsive) {
      window.removeEventListener('resize', this._windowResizeListener);
    }
  }

  _loop(reversed) {
    reversed ? this.prev() : this.next();

    if(this.#index === 0) {
      this.nloops += 1;
      if (this.#maxloops && this.nloops >= this.#maxloops) {
        this.stop();
        return;
      }
    }

    this.#loopTimeoutId = window.setTimeout(() => {
      this._loop(reversed);
    }, this.#options.speed);
  }

  _update () {
    if (this.sprite) {
      this.container.style.backgroundPositionX = -(this.#index % this.#options.perRow) * this.containerWidth + 'px';
      this.container.style.backgroundPositionY = -Math.floor(this.#index / this.#options.perRow) * this.containerHeight + 'px';
    } else {
      this.container.style.backgroundImage = `url("${this.#options.image[this.#index]}")`;
    }
  }

  _windowResizeListener() {
    this.container.style.height = this.containerHeight + 'px';
    this._update()
  }

  _initContainer() {
    if (!this.isResponsive) {
      this.container.style.width = this.containerWidth + 'px';
    }
    this.container.style.height = this.containerHeight + 'px';

    if (this.sprite) {
      this.container.style.backgroundImage = `url("${this.#options.image}")`;

      const cols = this.#options.perRow;
      const rows = Math.ceil(this.#options.count / this.#options.perRow);
      this.container.style.backgroundSize = (cols * 100) + '% ' + (rows * 100) + '%';
    }

    if (this.isResponsive) {
      window.addEventListener('resize', this._windowResizeListener);
    }

    this._update();
  }
}

// export default ThreeSixty;
